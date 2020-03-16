<?php
$user->requireLogin();




$id = $get->id();
$ask = $db->rowId('pudl_ask', 'ask_id', $id);

if (empty($ask)) \af\error(404);

if (!empty($ask['answer_time'])) {
	\af\error(422, 'This question has already been answered');
}

\af\affirm(401, $user->is($ask['receiver_id']));

$text = $get->string('text');
if (empty($text)) \af\error(422, 'Nothing to submit');

$db->updateId('pudl_ask', [
	'answer_time' => $db->time(),
	'answer_text' => $text,
], 'ask_id', $ask);


//ACTIVITY!!!
(new \af\activity($af, $user))->delete($id, 'answer', 'answered');


//NOTIFICATION!!!
$db->insert('pudl_notification', [
	'object_id'					=> $id,
	'object_type_id'			=> $af->type('answer'),
	'notification_user_from'	=> $user['user_id'],
	'notification_user_to'		=> $ask['sender_id'],
	'notification_timestamp'	=> $db->time(),
	'notification_read'			=> 0,
	'notification_text'			=> $ask['question_text'],
]);


echo '<script>refresh()</script>';
