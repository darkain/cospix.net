<?php


$db->begin();


$blacklist = [
	'number',
	'symbol',
	'con',
	'convention',
	'root',
	'administration',
	'administrator',
	'user',
	'gallerie',
	'list',
	'cosplay',
	'niche',
	'network',
	'oauth',
	'facebook',
	'twitter',
	'google',
	'amazon',
	'tumblr',
	'flickr',
	'yahoo',
	'cospix',
	'cospixnet',
	'option',
	'sitemap',
	'apache',
	'nginx',
	'hiphop',
	'squid',
	'hhvm',
	'php',
	'linux',
	'windows',
	'microsoft',
	'pfsense',
	'founder',
	'vince',
	'brian',
	'peter',
];


if (((int)$user['user_url']) === 0) die('ERROR: URL Already Set');

$name = $get->string('name');
if (empty($name)) die('ERROR: No URL Given');
if (strlen($name) < 2) die('ERROR: URL Is Too Short');
if (!ctype_alnum($name)) die('ERROR: Invalid Characters In URL');
if (ctype_digit(substr($name, 0, 1))) die('ERROR: URL Cannot Start With A Number');

if (is_dir("../../../$name")) die('ERROR: Restricted URL');
if (is_dir("../../../$name".'s')) die('ERROR: Restricted URL');

foreach ($blacklist as $item) {
	if (preg_match("/^$item(s)?$/", $name)) {
		die('ERROR: Invalid URL');
	}
}


$test = $db->rowId('pudl_user', 'user_url', $name, true);
if (!empty($test)) die('ERROR: URL Already In Use');


$user->update(['user_url'=>$name]);

echo '<script>refresh()</script>';


$db->commit();
