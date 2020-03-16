<?php
$user->requireLogin();

$profile = $db->row('pudl_user', [
	'user_id' => $get->id(),
	cpnFilterBanned(0),
]);
\af\affirm(404, $profile);
\af\affirm(401, !$user->is($profile), 'You cannot ask yourself questions!');

$text = $get->string('text');
if (empty($text)) \af\error(422, 'Nothing to ask!');

$id = $db->insert('pudl_ask', [
	'sender_id'		=> $user['user_id'],
	'receiver_id'	=> $profile['user_id'],
	'question_time'	=> $db->time(),
	'question_text'	=> $text,
]);


$db->insert('pudl_notification', [
	'object_id'					=> $id,
	'object_type_id'			=> $af->type('ask'),
	'notification_user_from'	=> $user['user_id'],
	'notification_user_to'		=> $profile['user_id'],
	'notification_timestamp'	=> $db->time(),
	'notification_read'			=> 0,
	'notification_text'			=> $text,
]);

echo '<div class="larger center">Your questions has been asked!</div>';
