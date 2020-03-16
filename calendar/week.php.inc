<?php

$size = $af->prometheus() ? 800 : 200;

//Pull event data
$events = $db->rows(
	[
		'ev' => _pudl_event($size),
		'fl' => 'pudl_file',
	],
	[
		'event_start' => pudl::between($start, $end),
		'fl.file_hash=th.file_hash',
	],
	[
		'event_start',
		'event_end',
		'event_name',
	]
);


//Create thumbnail URLs
$afurl->cdnAll($events, 'img', 'thumb_hash');


//Separate out the weeks
$last = false;
foreach ($events as &$event) {
	$week	= date('W', $event['event_start']-(AF_DAY*2));

	//TODO: week 53 is broken!! - check dates in December 2015 and January 2016
	if ($week == 53) $week = 52;

	if ($cal['month'] === 'dec'  &&  $week === '01') {
		$start		= strtotime(($cal['year']+1).'W'.$week)+(AF_DAY*2);
		$end		= strtotime(($cal['year']+1).'W'.$week)+(AF_DAY*8);
	} else {
		$start		= strtotime($cal['year'].'W'.$week)+(AF_DAY*2);
		$end		= strtotime($cal['year'].'W'.$week)+(AF_DAY*8);
	}
	$event['week']	= 'Week ' . $week . ' - ' . \af\time::daterange($start, $end);
	$event['range']	= \af\time::daterange($event['event_start'], $event['event_end']);

	$event['link_name']	= $event['event_name'];
	$event['name']		= $event['range'];

	if (empty($last)) $last = &$event;
	$event['total']	= 0;
	if ($event['week'] !== $last['week']) $last = &$event;
	$last['total']++;
} unset($event);
