<?php
$user->requireLogin();

\af\affirm(404,
	$gallery = $db->rowId('pudl_gallery', 'gallery_id', $get->id()),
	'Invalid Gallery'
);

\af\affirm(401, $user->is($gallery));


//UPCOMING EVENTS
$result = $db->group(
	['ue.*', 'ev.*', 'th.thumb_hash'],
	['ue'=>'pudl_user_event', 'ev'=>_pudl_event(200)],
	['ev.event_id=ue.event_id', 'ue.user_id'=>$user['user_id']],
	'ev.event_id',
	['ev.event_start'=>pudl::dsc()]
);
$events = $result->rows();
$result->free();

$afurl->cdnAll($events, 'img', 'thumb_hash');



$af->load('add.tpl');
	$af->field('gallery',	$gallery);
	$af->block('event',		$events);
$af->render();
