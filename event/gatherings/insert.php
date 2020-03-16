<?php
$user->requireLogin();


$db->begin();


$event = $db->rowId('pudl_event', 'event_id', $get->id());
\af\affirm(404, $event);

$start		= $get->timestamp('start');
$end		= $get->timestamp('end');
$name		= $get->string('name');
$location	= $get->string('location');

\af\affirm(422, $start,	'Invalid Start Time');
\af\affirm(422, $end,		'Invalid End Time');
\af\affirm(422, $name,	'Invalid Name');
\af\affirm(422, $location,'Invalid Location');

$id = $db->insert('pudl_gathering', [
	'event_id'				=> $event['event_id'],
	'gathering_start'		=> $start,
	'gathering_end'			=> $end,
	'gathering_name'		=> $name,
	'gathering_location'	=> $location,
]);

$db->insert('pudl_user_gathering', [
	'user_id'				=> $user['user_id'],
	'gathering_id'			=> $id,
	'gathering_attending'	=> 'host',
]);


$db->commit();


$event['url'] = $afurl->clean($event['event_name']);
echo "$afurl->base/event/$event[url]/gatherings/$id";
