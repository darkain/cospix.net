<?php
$ask = $db->rowId('pudl_ask', 'ask_id', $router->id);

if (empty($ask)) \af\error(404);

if (!empty($ask['answer_time'])) {
	$path = 'answered.tpl';
} else if ($user->is($ask['receiver_id'])) {
	$path = 'answer.tpl';
} else if ($user->is($ask['sender_id'])) {
	$path = 'asked.tpl';
} else {
	\af\error(401);
}

$af->header();


	//TODO:cpnFilterBanned
	$af->load($path);
		$af->field('ask', $ask);

		$af->field('sender', $db->row([
			'us' => _pudl_user(200),
		], [
			'user_id' => $ask['sender_id']
		]));

		$af->field('receiver', $db->row([
			'us'=>_pudl_user(200)
		], [
			'user_id' => $ask['receiver_id']
		]));
	$af->render();

$af->footer();
