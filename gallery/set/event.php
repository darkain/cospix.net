<?php
$user->requireLogin();

$id = $get->id();
$image = $db->rowId('pudl_gallery', 'gallery_id', $id);
\af\affirm(404, $image);
\af\affirm(401, $user->is($image));



/////



$text = $get('text');
if (empty($text)) {
	$db->updateId('pudl_gallery', [
		'event_id' => NULL,
	], 'gallery_id', $id);
	return;
}



/////



$event = $db->rowId('pudl_event', 'event_name', $text);
\af\affirm(404, $event);



/////




$db->updateId('pudl_gallery', [
	'event_id' => $event['event_id'],
], 'gallery_id', $id);



echo htmlspecialchars($get('text'));
