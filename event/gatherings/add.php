<?php
$user->requireLogin();

$event = $db->rowId('pudl_event', 'event_id', $get->id());
\af\affirm(404, $event);

$event['timezone'] = date('e');

$af->load('add.tpl');
	$af->field('event', $event);
$af->render();
