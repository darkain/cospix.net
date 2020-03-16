<?php

$user->requireLogin();

require_once('profile.php.inc');


//FOLLOW USER
$db->insert('pudl_follow',[
	'user_id'			=> $user['user_id'],
	'follow_id'			=> $profile['user_id'],
	'follow_timestamp'	=> $db->time(),
], 'user_id=user_id');


//NOTIFY USER THAT THEY'RE BEING FOLLOWED
$db->insert('pudl_notification', [
	'object_type_id'			=> $af->type('follow'),
	'notification_user_from'	=> $user['user_id'],
	'notification_user_to'		=> $profile['user_id'],
	'notification_timestamp'	=> $db->time(),
	'notification_read'			=> 0,
]);


echo '- Unfollow';
