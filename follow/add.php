<?php
$user->requireLogin();

//TODO: REPLACE THESE WITH THE NEW PROFILE VERSIONS

$follow = $db->rowId('pudl_user', 'user_id', $get->id());
\af\affirm(404, $follow);
\af\affirm(422, !$user->is($follow));

//TODO cpnFilterBanned(),

//FOLLOW USER
$db->insert('pudl_follow', [
	'user_id'			=> $user['user_id'],
	'follow_id'			=> $follow['user_id'],
	'follow_timestamp'	=> $db->time(),
], true);


//NOTIFY USER THAT THEY'RE BEING FOLLOWED
$db->insert('pudl_notification', [
	'object_type_id'			=> $af->type('follow'),
	'notification_user_from'	=> $user['user_id'],
	'notification_user_to'		=> $follow['user_id'],
	'notification_timestamp'	=> $db->time(),
	'notification_read'			=> 0,
]);
