<?php
$user->requireLogin();


$db->begin();


$gallery = $db->rowId('pudl_gallery', 'gallery_id', $get->id('galleryid'));
\af\affirm(404, $gallery, 'Invalid Gallery');
\af\affirm(401, $user->is($gallery));


$event = $db->rowId('pudl_event', 'event_id', $get->id('eventid'));
\af\affirm(404, $event, 'Invalid Event');

/*
We're now allowing users to tag from ANY event - makes it easier on them!
if (!$db->clauseExists('pudl_user_event', [
	'user_id'	=> $user['user_id'],
	'event_id'	=> $event['event_id'],
])) \af\error(401);
*/

$db->insert('pudl_gallery_event', [
	'gallery_id'	=> $gallery['gallery_id'],
	'event_id'		=> $event['event_id'],
], true);



$db->commit();
$af->ok();
