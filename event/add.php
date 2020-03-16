<?php

////////////////////////////////////////////////////////////
//ADMIN ONLY
////////////////////////////////////////////////////////////
$user->requireAccessStaff('event');




////////////////////////////////////////////////////////////
//WE CANNOT DUPLICATE EVENTS!
////////////////////////////////////////////////////////////
if ($db->idExists('pudl_event', 'event_name', $get->string('name'))) {
	echo 'Event already exists!';
	exit;
}




////////////////////////////////////////////////////////////
//START TRANSACTION
////////////////////////////////////////////////////////////
$db->begin();




////////////////////////////////////////////////////////////
//PULL SUBMITTED DATA
////////////////////////////////////////////////////////////
$start	= strtotime($get->string('start'));
$end	= strtotime($get->string('end'));
if (empty($end))	$end	= $start;
if (empty($start))	$start	= $end;

$twitter = trim(str_replace(
	[
		'http://twitter.com/',
		'https://twitter.com/',
		'http://www.twitter.com/',
		'https://www.twitter.com/',
		'@', '/', '#', '!',
	],
	'',
	$get->string('twitter')
));




////////////////////////////////////////////////////////////
//CREATE OBJECT TO BE INSERTED
////////////////////////////////////////////////////////////
$insert = [
	'event_added_by'	=> $user['user_id'],
	'event_start'		=> $start,
	'event_end'			=> $end,
	'event_name'		=> $get->string('name'),
	'event_location'	=> $get->string('location'),
	'event_venue'		=> $get->string('venue'),
	'event_website'		=> $get->string('site'),
	'event_description'	=> $get->string('description'),
	'event_twitter'		=> $twitter,
];
if (empty($insert['event_name'])) \af\error(422);




////////////////////////////////////////////////////////////
//PULL GROUP INFORMATION, AND INHERIT DATA
////////////////////////////////////////////////////////////
if ($get->string('group')) {
	$group = $get->string('group');

	$event = $db->rowId(
		'pudl_event',
		is_numeric($group) ? 'event_id' : 'event_name',
		$group
	);

	if ($event) {
		$insert['event_icon']			= $event['event_icon'];

		if (!empty($event['event_youtube'])) {
			$insert['event_youtube']	= $event['event_youtube'];
		}

		if (!empty($event['event_organizer'])){
			$insert['event_organizer']	= $event['event_organizer'];
		}

		if ($event['event_group']) {
			$insert['event_group']		= $event['event_group'];
		} else {
			$insert['event_group']		= $event['event_id'];

			$db->updateId('pudl_event', [
				'event_group'			=> $event['event_id'],
			], 'event_id', $event['event_id']);
		}
	}
}




////////////////////////////////////////////////////////////
//INSERT THE NEW EVENT OBJECT
////////////////////////////////////////////////////////////
$newid = $db->insert('pudl_event', $insert);




////////////////////////////////////////////////////////////
//INHERIT EXISTING SOCIAL MEDIA LINKS
////////////////////////////////////////////////////////////
if (!empty($insert['event_group'])) {
	$result = $db->orderGroup(
		['es.*', 'ev.event_start'],
		['ev'=>'pudl_event', 'es'=>'pudl_event_social'],
		[
			'ev.event_id=es.event_id',
			'event_group' => $insert['event_group'],
		],
		'social_type',
		['event_start'=>pudl::dsc()]
	);

	while ($item = $result->row()) {
		$db->insert('pudl_event_social', [
			'event_id'		=> $newid,
			'social_type'	=> $item['social_type'],
			'social_url'	=> $item['social_url'],
		]);
	}
	$result->free();
}




////////////////////////////////////////////////////////////
//COMMIT ALL CHANGES BACK TO THE DATABASE
////////////////////////////////////////////////////////////
$db->commit();




////////////////////////////////////////////////////////////
//REDIRECT TO THE NEWLY CREATED EVENT'S PAGE
////////////////////////////////////////////////////////////
$afurl->redirect(['event', $newid]);
