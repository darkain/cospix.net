<?php

$user->requireAccessStaff('event');

$new = $db->rowId('pudl_event', 'event_id', $get->id());

if ($new  &&  $get('dir')=='next') {
	//ADD A YEAR TO THE DATES
	$new['event_start']	+= (AF_YEAR - AF_DAY);
	$new['event_end']	+= (AF_YEAR - AF_DAY);
	$new['group_name']	= $new['event_name'];

	for ($x=2050; $x>1970; $x--) {
		$new['event_name'] = str_replace($x, $x+1, $new['event_name']);
	}

} else if ($new  &&  $get('dir')=='prev') {
	//ADD A YEAR TO THE DATES
	$new['event_start']	-= (AF_YEAR - AF_DAY);
	$new['event_end']	-= (AF_YEAR - AF_DAY);
	$new['group_name']	= $new['event_name'];

	for ($x=1970; $x<2050; $x++) {
		$new['event_name'] = str_replace($x, $x-1, $new['event_name']);
	}

} else {
	$new = [
		'group_name'		=> '',
		'event_id'			=> '',
		'event_group'		=> '',
		'event_start'		=> $get('start') ? $get('start') : $db->time(),
		'event_end'			=> $get('end') ? $get('end') : $db->time(),
		'event_name'		=> $get('name'),
		'event_location'	=> $get('location'),
		'event_venue'		=> $get('venue'),
		'event_website'		=> $get('url'),
		'event_twitter'		=> $get('twitter'),
		'event_lat'			=> '',
		'event_lon'			=> '',
		'event_icon'		=> '',
		'event_description'	=> '',
	];
}

$af->renderPage('new.tpl', ['new'=>$new]);
