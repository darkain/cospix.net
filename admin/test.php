<?php
\af\affirm(500,
	extension_loaded('openssl'),
	'This page requires the PHP OpenSSL extension' . "\n" .
	'pkg install php73-openssl'
);


//date_default_timezone_set('GMT');

$tester = 'https://validator.darkain.com';
$domain = 'https://beta.cospix.net';
//$domain = 'http://cospix.net';

$paths = [
	'/',

	'/discover',

	'/login',

	'/profile',
	'/profile/a',
	'/profile/0',
	'/profile/other',
	'/profile/new',
	'/profile/map',

	'/darkain',
	'/darkain/feed',
	'/darkain/photos',
	'/darkain/costumes',
	'/darkain/galleries',
	'/darkain/articles',
	'/darkain/questions',
	'/darkain/teams',
	'/darkain/followers',
	'/darkain/following',
	'/darkain/events',
	'/darkain/gallery/59375',

	'/4',
	'/4/costumes',
	'/4/costume/111',
	'/1883/costume/738',

	'/costume',
	'/costume/new',
	'/costume/total',
	'/gallery',
	'/gallery/newest',
	'/gallery/total',

	'/image/478f5c8f33847eba360619e6d3912c7f?gallery=27190',
	'/image/7c10300d989915b9d63e44e3e70d8217?gallery=59375',
	'/image/26fe3a6f147bd982d08a032f9fcdb382?gallery=60691',

//	'/image/featured',
//	'/image/featured/2015-10',

	'/ask/624',

	'/article',
	'/article/168',

	'/map',
	'/calendar',
	'/calendar/2014/jul',
	'/calendar/2010/dec',

	'/event/sakura-con%202018',
//	'/event/sakura-con%202018/map',
//	'/event/sakura-con%202018/costumes',
	'/event/sakura-con%202018/galleries',
	'/event/sakura-con%202018/photos',
	'/event/sakura-con%202018/attendees',
//	'/event/sakura-con%202018/reports',

	'/tag',
	'/tag/universe',
	'/tag/series',
	'/tag/series/trending',
	'/tag/series/r',
	'/tag/series/rwby',
	'/tag/series/rwby/episodes',
	'/tag/series/rwby/characters',
	'/tag/series/rwby/episodes/pYW2GmHB5xs',
	'/tag/series/rwby/cosplayers',
//	'/tag/series/rwby/costumes',
	'/tag/series/rwby/photos',
	'/tag/series/neon%20genesis%20evangelion/universe',
	'/tag/character',
	'/tag/character/cinder%20fall',
	'/tag/character/cinder%20fall/series',
	'/tag/character/cinder%20fall/references',
	'/tag/character/cinder%20fall/references/29360',
	'/tag/outfit',
	'/tag/lens',
	'/tag/lens/ef50mm%20f⁄1.4%20usm/camera',
	'/tag/lens/ef50mm%20f⁄1.4%20usm/software',
	'/tag/camera',
	'/tag/camera/canon%20eos%2030d/lens',
	'/tag/software',

	'/vendor',
/*	'/vendor/1',
	'/vendor/1/staff',
	'/vendor/1/cosplayers',
	'/vendor/1/costumes',
	'/vendor/1/photos',
	'/vendor/1/services',
	'/vendor/1/services/1', */

	'/tools',
	'/tools/hotel',

	'/staff',
];


array_shift($argv);

if (!empty($af)) {
	array_shift($argv);

	if (!empty($argv)) {
		if ($argv[0] === 'beta') {
			$domain = 'http://beta.cospix.net';
			array_shift($argv);
		} else if ($argv[0] === 'live') {
			$domain = 'http://cospix.net';
			array_shift($argv);
		}
	}
}

if (!empty($argv)) $paths = $argv;



function html_test($path, $secure) {
	global $af, $afurl, $errors, $domain, $tester;


	if (!$secure) {
		echo \af\cli::fgCyan('GUEST: ') . \af\cli::bold($path);
		$hash	= '';
	} else {
		echo \af\cli::fgBlue(true,'ADMIN: ') . \af\cli::bold($path);
		$hash	= ((strpos($path, '?') === false)?'?':'&')
				. 'securelogin='.md5($af->config->afkey().date('i'));
	}

	$http_response_header = ['CONNECTION TIMED OUT'];

	$html	= @file_get_contents($domain.$path.$hash);
	if (empty($html)) {
		if (!$secure  &&  strpos($http_response_header[0], ' 401 ')) {
			echo \af\cli::fgYellow("    \t[" . $http_response_header[0] . "]\n");
		} else {
			echo \af\cli::fgRed("    \t[" . $http_response_header[0] . "]\n");
			$errors = true;
		}
		return;
	}

	echo \af\cli::fgBlue(" ...\t");

	$data	= $afurl->post($tester, [
		'out'		=> 'json',
		'content'	=> $html,
	]);

	if (!empty($data['error'])) {
		echo \af\cli::fgRed('[' . $data['error'] . "]\n");
		$errors = true;
		return;
	}

	if (!empty($data['http_code'])  &&  $data['http_code'] !== 200) {
		$content	= $data['content'];
		$content	= str_replace('Powered by Jetty://', '', $content);
		$content	= strip_tags($content);
		$content	= preg_replace('/Error \d\d\d/', '', $content);
		$content	= preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $content);
		$lines		= explode("\n", trim($content));
		$lines[0]	= '[' . $lines[0] . ']';
		foreach ($lines as &$line) { $line = trim($line); } unset($line);
		echo \af\cli::fgRed(implode("\n", $lines) . "\n");
		$errors		= true;
		return;
	}

	$json = @json_decode($data['content']);

	if (empty($json->messages)) {
		if (strpos($http_response_header[0], ' 200 ')) {
			echo \af\cli::fgGreen('[' . $http_response_header[0] . "]\n");
		} else {
			echo \af\cli::fgYellow('[' . $http_response_header[0] . "]\n");
		}
		return;
	}

	static $retry = 0;
	if ($json->messages[0]->message === 'Read timed out') {
		if ($retry++ < 1) {
			echo \af\cli::fgRed(' - ' . $json->messages[0]->message . "\n");
			html_test($path);
		} else {
			echo "\n";
			var_export($json->messages);
			echo "\n";
			$errors = true;
		}
		$retry--;
		return;
	}

	echo "\n";
	var_export($json->messages);
	echo "\n";
	$errors = true;
}


echo 'Domain: ' . \af\cli::bold($domain) . "\n\n";

$errors	= false;

foreach ($paths as $path) {
	if ($path[0] !== '/') $path = '/' . $path;
	html_test($path, true);
	html_test($path, false);
}


if ($errors) {
	echo "\n\n --- ERRORS WERE FOUND --- \n\n";
	exit(1);
}
