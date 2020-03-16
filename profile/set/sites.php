<?php

//	TODO: SEE IF THIS FILE IS DEPRECATED. IT MAY NOT BE CALLED AT ALL ANYMORE!?

$user->requireLogin();

$db->deleteId('pudl_user_site', $user);

$sites = $get->stringArray('sites');


$websites = [
	'deviantart'	=> array('suffix'=>'.deviantart.com'),
	'facebook'		=> array('prefix'=>'www.facebook.com/'),
	'flickr'		=> array('prefix'=>'www.flickr.com/photos/'),
	'google'		=> array('prefix'=>'plus.google.com/'),
	'livejournal'	=> array('suffix'=>'.livejournal.com'),
	'reddit'		=> array('prefix'=>'www.reddit.com/user/'),
	'steam'			=> array('prefix'=>'steamcommunity.com/id/'),
	'tumblr'		=> array('suffix'=>'.tumblr.com'),
	'twitter'		=> array('prefix'=>'twitter.com/'),
	'youtube'		=> array('prefix'=>'www.youtube.com/'),
];


$i=0;
foreach ($sites as $key => $val) {
	if (!array_key_exists($key, $websites)) continue;
	if (empty($val)) continue;

	$db->insert('pudl_user_site', [
		'user_id'	=> $user->user_id,
		'order_id'	=> $i++,
		'site_name'	=> $key,
		'site_url'	=> $val
	], true);
}
