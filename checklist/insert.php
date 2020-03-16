<?php

$user->requireLogin();


//TRANSACTIONS ARE AWESOME
$db->begin();


switch ($get->string('type')) {
	case 'event':
		$event = $db->rowId('pudl_event', 'event_id', $get->id(), true);
		\af\affirm(404, $event);
	break;

	case 'gallery':
		$gallery = $db->rowId('pudl_gallery', 'gallery_id', $get->id(), true);
		\af\affirm(404, $gallery);
		\af\affirm(401, $user->is($gallery));
	break;
}



//Push existing checklists back in sort order
$db->updateId('pudl_checklist',
	'checklist_sort=checklist_sort+1',
	'user_id', $user
);



//Insert new empty checklist
$db->insert('pudl_checklist', [
	'event_id'				=> !empty($event)	? $event['event_id']		: NULL,
	'gallery_id'			=> !empty($gallery)	? $gallery['gallery_id']	: NULL,
	'user_id'				=> $user['user_id'],
	'checklist_timestamp'	=> $db->time(),
	'checklist_name'		=> 'Checklist',
	'checklist_data'		=> [['text'=>'Do something awesome!', 'check'=>0]],
]);



//TRANSACTIONS ARE AWESOME
$db->commit();
