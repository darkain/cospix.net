<?php

\af\affirm(404,
	$events = $db->selectRows(
		'*',
		['ev'=>_pudl_event()],
		['event_group' => $router->id],
		['event_start' => pudl::dsc()]
	)
);


$af->title = $events[0]['event_name'];


$afurl->cdnAll($events, 'img', 'thumb_hash');


foreach ($events as &$item) {
	$item['year']	= date('Y', $item['event_start']);
	$item['range']	= \af\time::daterange($item['event_start'], $item['event_end']);
} unset($item);


$af	->header()
		->load('_virtual.tpl')
			->block('eventlist', $events)
		->render()
	->footer();
