<?php
$user->requireAdmin();

$text = $get->string('text');
if (empty($text)) return;

$db->insert('pudl_devlog', [
	'log_time' => $db->time(),
	'log_text' => $text,
	'log_user' => $user['user_id'],
]);
