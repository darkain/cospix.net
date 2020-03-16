<?php

if (empty($get('query'))) {
	$result = $db->group(
		['ue.*', 'ev.*', 'th.thumb_hash'],
		['ue'=>'pudl_user_event', 'ev'=>_pudl_event(200)],
		['ev.event_id=ue.event_id', 'ue.user_id'=>$user['user_id']],
		'ev.event_id',
		['ev.event_start'=>pudl::dsc()]
	);

	if (!$result->count()) {
		$result = $db->group(
			['sort' => pudl::count(), 'ev.*', 'th.thumb_hash'],
			['ev'=>_pudl_event(200), 'ue'=>'pudl_user_event'],
			'ue.event_id=ev.event_id',
			'ev.event_id',
			['sort'=>pudl::dsc(), 'ev.event_name'],
			12
		);
	}

} else {
	$result = $db->group(
		['ev.*', 'th.thumb_hash'],
		['ev' => _pudl_event(200)],
		['ev.event_name' => pudl::like($get('query'))],
		'ev.event_id',
		['ev.event_start'=>pudl::dsc()]
	);
}

$events = $result->rows();
$result->free();

$afurl->cdnAll($events, 'img', 'thumb_hash');


$af->load('event.tpl');
	$af->block('event',		$events);
$af->render();
