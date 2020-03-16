<?php
$user->requireLogin();


$db->updateId('pudl_notification', [
	'notification_read' => 1,
], 'notification_user_to', $user['user_id']);


$af->ok();
