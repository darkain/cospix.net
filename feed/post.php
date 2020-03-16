<?php

$user->requireLogin();


$text = $get('text');
if ($text === '') return;


$db->begin();


$id = $db->insert('pudl_activity', [
	'user_id'				=> $user['user_id'],
	'activity_timestamp'	=> $db->time(),
	'object_type_id'		=> $af->type('activity'),
	'activity_verb'			=> '',
	'activity_text'			=> $text,
]);


$db->updateId('pudl_activity', [
	'object_id'				=> $id,
], 'activity_id', $id);


$db->commit();
