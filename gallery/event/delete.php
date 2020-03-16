<?php
$user->requireLogin();


$id = $get->id('galleryid');
$gallery = $db->rowId('pudl_gallery', 'gallery_id', $id);
\af\affirm(404, $gallery, 'Invalid Gallery');
\af\affirm(401, $user->is($gallery));


$db->delete('pudl_gallery_event', [
	'gallery_id'	=> $id,
	'event_id'		=> $get->id('eventid'),
]);


$af->ok();
