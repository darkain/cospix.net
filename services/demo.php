<?php

$af->title = 'Live Demo';

$events = $db->rowsId('pudl_event', 'event_added_by', $user['user_id']);


$af	->header()
		->load('demo.tpl')
			->block('event', $events)
		->render()
	->footer();
