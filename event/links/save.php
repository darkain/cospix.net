<?php

$user->requireAccessStaff('event', $event);

$id = $get->id();

$start	= strtotime($get->string('start'));
$end	= strtotime($get->string('end'));
if (empty($end)) $end = $start;

if ($end < $start) {
	$tmp	= $start;
	$start	= $end;
	$end	= $tmp;
}


$twitter = trim(str_replace([
	'http://twitter.com/',
	'https://twitter.com/',
	'@',
	'/',
], '', $get->string('twitter')));



$db->updateId('pudl_event', [
	'event_start'	=> $start,
	'event_end'		=> $end,
	'event_twitter'	=> $twitter,
	'event_website'	=> $get->string('website'),
	'event_details'	=> $get->string('canceled') ? 'canceled' : '',
], 'event_id', $id);




///////////////////




$social = $get->stringArray('social');
foreach ($social as $key => $val) {
	if (empty($val)) {
		$db->delete('pudl_event_social', [
			'event_id'		=> $id,
			'social_type'	=> $key,
		]);

	} else {
		$db->insert('pudl_event_social', [
			'event_id'		=> $id,
			'social_type'	=> $key,
			'social_url'	=> $val,
		], true);
	}
}
