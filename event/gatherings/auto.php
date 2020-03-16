<?php
//Cannot use autocomplete without signing in!
$user->requireLogin();


$event = $db->rowId('pudl_event', 'event_name', $get('event'));
\af\affirm(404, $event);

$text = $get->search('term');


$rows = $db->selectRows([
		'label' => 'gt.gathering_name',
	], [
		'gt' => ['pudl_gathering',
			['left' => ['ug'=>'pudl_user_gathering'], 'on' => [
				'gt.gathering_id=ug.gathering_id',
				'ug.user_id' => $user['user_id'],
			]]
		]
	], [
		'gt.gathering_name'	=> pudl::like($text),
		'gt.event_id'		=> $event['event_id'],
	], [
		'user_id'			=> pudl::dsc(),
		'gathering_name'
	],
	10
);

$af->json($rows);
