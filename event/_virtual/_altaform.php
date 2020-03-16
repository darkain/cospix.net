<?php

////////////////////////////////////////////////////////////////////////////////
//PULL EVENT DATA
////////////////////////////////////////////////////////////////////////////////
$event = $db->rowId(['ev'=>_pudl_event(150)], 'event_name', $router->virtual[0]);




////////////////////////////////////////////////////////////////////////////////
//IF EVENT RENAMED, REDIRECT
////////////////////////////////////////////////////////////////////////////////
if (empty($event)) {
	$event = $db->selectRow(
		'ev.event_name',
		['er'=>'pudl_event_rename', 'ev'=>'pudl_event'],
		['er.event_name'=>$router->virtual[0], 'ev.event_id=er.event_id']
	);

	if (empty($event)) {
		$event = $db->rowId('pudl_event', 'event_id', $router->virtual[0]);
	}

	if (!empty($event)) {
		$afurl->redirect([
			'event',
			$event['event_name'],
			(!empty($af->title) ? $af->title : '')
		]);
	}
}




////////////////////////////////////////////////////////////////////////////////
//IF NO EVENT FOUND, ERROR OUT!!
////////////////////////////////////////////////////////////////////////////////
\af\affirm(404, $event);




////////////////////////////////////////////////////////////////////////////////
//FIX EVENT OBJECT ID AND  GROUP ID
////////////////////////////////////////////////////////////////////////////////
$event['object_id'] = $event['event_id'];

if (empty($event['event_group'])) {
	$event['event_group'] = $event['event_id'];
}




////////////////////////////////////////////////////////////////////////////////
//BUILD PROFILE DATA
////////////////////////////////////////////////////////////////////////////////
$profile = [
	'type'			=> 'event',
	'id'			=> $event['event_id'],
	'url'			=> $afurl(['event', $event['event_name']]),
	'name'			=> $event['event_name'],
	'img'			=> $afurl->cdn($event['thumb_hash']),
	'sub'			=> $event['event_venue'] . ', ' . $event['event_location'],
	'edit'			=> $user->hasAccessStaff('event', $event),
	'imgdefault'	=> 'convention.svg',
	'object'		=> &$event,
	'cover'			=> $afurl->cdn($event['file_hash']),
];
/*
if ($user->loggedIn()) {
	if ($db->clauseExists('pudl_user_event', [
		'user_id'	=> $user['user_id'],
		'event_id'	=> $event['event_id'],
	])) {
		$profile['button'] = '- Leave';
	} else {
		$profile['button'] = '+ Attend';
	}
}
*/



////////////////////////////////////////////////////////////////////////////////
//ACTION ITEMS
////////////////////////////////////////////////////////////////////////////////
$actions = [];




////////////////////////////////////////////////////////////////////////////////
//LOGGED IN, ADD ATTENDING INFO
////////////////////////////////////////////////////////////////////////////////
if ($user->loggedIn()) {
	if ($db->clauseExists('pudl_user_event', [
		'user_id'	=> $user['user_id'],
		'event_id'	=> $event['event_id'],
	])) {
		$actions += ['Leave' => [
			'count'	=> '-',
			'link'	=> 'leave',
		]];
	} else {
		$actions += ['Attend' => [
			'count'	=> '+',
			'link'	=> 'attend',
		]];
	}
}




////////////////////////////////////////////////////////////////////////////////
//BUILD COVER PHOTO DATA
////////////////////////////////////////////////////////////////////////////////
$actions += [
	'Attendees'		=> [
		'count'		=> $db->countId('pudl_user_event', 'event_id', $event),
		'link'		=> 'attendees'
	],

	'Galleries'		=> [
		'count'		=> $db->countId('pudl_gallery', 'event_id', $event),
		'link'		=> 'galleries'
	],
];




////////////////////////////////////////////////////////////////////////////////
//BUILD ADMIN LINKS
////////////////////////////////////////////////////////////////////////////////
if ($profile['edit']) $actions += [
	'Edit'			=> [
		'count'		=> 0,
		'link'		=> 'edit',
	],

	'Add Next'		=> [
		'count'		=> 0,
		'link'		=> 'new?dir=next',
	],

	'Add Prev'		=> [
		'count'		=> 0,
		'link'		=> 'new?dir=prev',
	],
];
