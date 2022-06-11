<?php

//FIX FOR HHVM
require_once('_buildurl/src/http_build_url.php');




////////////////////////////////////////////////////////////////////////////////
// BLOCK LIST OF SPAMMY DOMAINS
////////////////////////////////////////////////////////////////////////////////
$blocklist = [
	'viromin.com',
	'bookmark-share.com',
	'bookmarkmiracle.com',
	'finanzas.kelisto.es',
	'hantsservicesltd.co.uk',
	'mythem.es',
];





////////////////////////////////////////////////////////////////////////////////
// GET THE PATH
////////////////////////////////////////////////////////////////////////////////
$path = $afurl->uri;

if (substr($path, 0, strlen($afurl->base)) == $afurl->base) {
	$path = substr($path, strlen($afurl->base));
}

if (substr($path, 0, strlen("/{$router->part[1]}/")) == "/{$router->part[1]}/") {
	$path = substr($path, strlen("/{$router->part[1]}/"));
}

$parsed = parse_url($path);
if (empty($parsed['scheme'])) $path = 'https://' . $path;




////////////////////////////////////////////////////////////////////////////////
// VALIDATE THE URL
////////////////////////////////////////////////////////////////////////////////
\af\affirm(400,
	filter_var($path, FILTER_VALIDATE_URL),
	'Invalid URL'
);

foreach ($blocklist as $item) {
	\af\affirm(400,
		stripos($path, $item) === false,
		'Invalid Domain'
	);
}

\af\affirm(400,
	strlen($path) < 255,
	'URL Too Long'
);




////////////////////////////////////////////////////////////////////////////////
// CHECK TO SEE IF WE ALREADY HAVE A REDIRECT FOR THIS
////////////////////////////////////////////////////////////////////////////////
$data = $db->rowId('pudl_anchor', 'anchor_source', $path);
if (!empty($data)) {
	$db->updateId('pudl_anchor', [
		'anchor_clicks' => pudl::_increment(1),
	], 'anchor_id', $data['anchor_id']);

	if (empty($data['anchor_dest'])) {
		$afurl->redirect($data['anchor_source']);

	//TODO: REPLACE HTTP_BUILD_URL SINCE THIS REQUIRES A LARGER THAN WANTED DEPENDENCY
	} else if (substr($data['anchor_dest'], 0, 1) === '/') {
		$parsed = parse_url($data['anchor_source']);
		$parsed['path'] = $data['anchor_dest'];
		$data['anchor_dest'] = http_build_url($parsed);

	} else if (strpos($data['anchor_dest'], '://') === false) {
		$data['anchor_dest'] = $data['anchor_source'] . $data['anchor_dest'];
	}

	$data['anchor_dest'] = str_replace(
		'~~~ALTAFORM~AWS~TAG~~~',
		$afconfig->amazon['tag'],
		$data['anchor_dest']
	);

	$afurl->redirect($data['anchor_dest']);
}




////////////////////////////////////////////////////////////////////////////////
// TEST IF THIS IS A REDIRECT WE'RE LINKING TO
////////////////////////////////////////////////////////////////////////////////
$dest = preg_replace(
	'~http:\/\/[^>]*?amazon.(.*)\/([^>]*?ASIN|gp\/product|exec\/obidos' .
	'\/tg\/detail\/-|[^>]*?dp)\/([0-9a-zA-Z]{10})[a-zA-Z0-9#\/\*\-\?\&\%\=\,\+\._;]*~i',
	'http://www.amazon.$1/dp/$3/?tag=~~~ALTAFORM~AWS~TAG~~~',
	$path
);

if ($dest === $path) {
	$dest = '';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,				$path);
	curl_setopt($ch, CURLOPT_HEADER,			true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION,	false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,	true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,	2);
	curl_setopt($ch, CURLOPT_TIMEOUT,			2);

	$data = curl_exec($ch);

	if (!curl_errno($ch)) {
		$size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$text = substr($data, 0, $size);
		$info = explode("\r\n", $text);

		$list = [];
		foreach ($info as $item) {
			$pos = strpos($item, ':');
			if ($pos === false) continue;

			$name = strtolower(trim(substr($item, 0, $pos)));
			$val  = trim(substr($item, $pos+1));

			$list[$name] = $val;
		}

		if (!empty($list['location'])) {
			$dest = trim(preg_replace(
				'~http:\/\/[^>]*?amazon.(.*)\/([^>]*?ASIN|gp\/product|exec\/obidos' .
				'\/tg\/detail\/-|[^>]*?dp)\/([0-9a-zA-Z]{10})[a-zA-Z0-9#\/\*\-\?\&\%\=\,\+\._;]*~i',
				'http://www.amazon.$1/dp/$3/?tag=~~~ALTAFORM~AWS~TAG~~~',
				$list['location']
			));
		}
	}
}




////////////////////////////////////////////////////////////////////////////////
// STORE REDIRECT DATA
////////////////////////////////////////////////////////////////////////////////
$db->insert('pudl_anchor', [
	'anchor_source'	=> $path,
	'anchor_dest'	=> $dest,
], true);




////////////////////////////////////////////////////////////////////////////////
// FINAL REDIRECT
////////////////////////////////////////////////////////////////////////////////
if (empty($dest)) $afurl->redirect($path);


//TODO: REPLACE HTTP_BUILD_URL SINCE THIS REQUIRES A LARGER THAN WANTED DEPENDENCY
if (substr($dest, 0, 1) === '/') {
	$parsed = parse_url($path);
	$parsed['path'] = $dest;
	$dest = http_build_url($parsed);

} else if (strpos($dest, '://') === false) {
	$dest = $path . $dest;
}


$afurl->redirect(str_replace(
	'~~~ALTAFORM~AWS~TAG~~~',
	$afconfig->amazon['tag'],
	$dest
));
