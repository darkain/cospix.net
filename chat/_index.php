<?php

if (!$user->loggedIn()) {
	return $router->replace('login');
}


if ($af->device() === 'desktop')	\af\device::redetect();
if ($af->device() === 'mobile')		\af\device::set('tablet');


\af\affirm(404,
	$room = $db->row('pudl_chatroom')
);


$af->title = $room['chat_title'] . ' Chat';


$af	->css('_index.css')
	->header()
		->load('_index.tpl')
			->field('room', $room)
		->render()
	->footers('footer', 0)
	->footer();
