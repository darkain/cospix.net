<?php

\af\affirm(404,
	$events = $db->rows([
		'ev' => _pudl_event(),
		'or' => 'pudl_event_organizer',
	], [
		'ev.event_organizer=or.organizer_id',
		'or.organizer_name' => $router->virtual[0]
	], [
		'event_end' => pudl::dsc()
	])
);


$af->title = $events[0]['organizer_name'];


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
