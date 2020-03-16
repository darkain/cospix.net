<?php


////////////////////////////////////////////////////////////////////////////////
//OPEN GRAPH / MICRODATA / CARDS INTEGRATION
////////////////////////////////////////////////////////////////////////////////
$og['itemtype']	= 'SocialEvent';
$og['tagline']	= 'location';




////////////////////////////////////////////////////////////////////////////////
//PRETTY TEXT
////////////////////////////////////////////////////////////////////////////////
$event['description'] = afString::linkify($event['event_description']);




////////////////////////////////////////////////////////////////////////////////
//FACEBOOK FEED
////////////////////////////////////////////////////////////////////////////////
$event['facebook'] = $db->row('pudl_event_social', [
	'event_id' => $event['event_id'],
	['social_type'=>'Facebook']
]);

if (is_array($event['facebook'])) {
	if (strpos($event['facebook']['social_url'], '/events/')) {
		$event['facebook'] = false;
	} else if (strpos($event['facebook']['social_url'], '/groups/')) {
		$event['facebook'] = false;
	}
}




////////////////////////////////////////////////////////////////////////////////
//GENERATE DATE STRINGS
////////////////////////////////////////////////////////////////////////////////
$event['event_start_string']	= date('m/d/Y', $event['event_start']);
$event['event_end_string']		= date('m/d/Y', $event['event_end']);

if ($event['event_start'] > $db->time()) {
	$event['event_countdown'] = \af\time::since($event['event_start'], -1);
} else if ($event['event_start'] > $db->time()-AF_DAY*2) {
	$event['event_countdown'] = 'HAPPENING NOW';
} else {
	$event['event_countdown'] = NULL;
}




////////////////////////////////////////////////////////////////////////////////
//PULL EVENT GROUP INFORMATION
////////////////////////////////////////////////////////////////////////////////
$render['eventlist'] = [];

if (!empty($event['event_group'])) {
	$render['eventlist'] = $db->rows(
		['ev' => _pudl_event(100)],
		['ev.event_group' => $event['event_group']],
		['event_start'=>pudl::dsc()]
	);
}

foreach ($render['eventlist'] as &$item) {
	$item['range'] = \af\time::daterange($item['event_start'], $item['event_end']);

	$item['img'] = $afurl->cdn($item, 'thumb_hash');
	if (empty($item['img'])) $item['img'] = $afurl->cdn($item, 'event_icon');

	$days = round(($item['event_start'] - $db->time()) / AF_DAY);
	if ($days == 1) {
		$item['countdown'] = 'NOW!';
	} else if ($days > 1) {
		$item['countdown'] = $days . ' days';
	}
} unset($item);

$event['related'] = count($render['eventlist']);




////////////////////////////////////////////////////////////////////////////////
//PULL OTHER EVENTS FOR THE SAME WEEKEND
////////////////////////////////////////////////////////////////////////////////
$start	= strtotime('Y' . date('Y',$event['event_start']) . 'W' . date('W',$event['event_start']));
$end	= $start + AF_WEEK - 1;

$render['weekend'] = $db->rows(
	['ev' => _pudl_event(100)],
	[
		'event_start'	=> pudl::between($start, $end-1),
		'event_id'		=> pudl::neq($event['event_id']),
		cpnFilterCanceled(),
	],
	['event_start', 'event_name']
);

foreach ($render['weekend'] as &$item) {
	$item['range'] = \af\time::daterange($item['event_start'], $item['event_end']);

	$item['img'] = $afurl->cdn($item, 'thumb_hash');
	if (empty($item['img'])) $item['img'] = $afurl->cdn($item, 'event_icon');

	$days = round(($item['event_start'] - $db->time()) / AF_DAY);
	if ($days == 1) {
		$item['countdown'] = 'NOW!';
	} else if ($days > 1) {
		$item['countdown'] = $days . ' days';
	}
} unset($item);




////////////////////////////////////////////////////////////////////////////////
//PULL EVENT LOCATION DATA
////////////////////////////////////////////////////////////////////////////////
if (empty($event['event_lat'])  &&  empty($event['event_lat'])) {
	$location = $db->row('pudl_geolocation', [
		'location' => "$event[event_venue], $event[event_location]",
	]);

	if (!empty($location)) {
		$event['event_lat'] = $location['lat'];
		$event['event_lon'] = $location['lon'];
		$db->updateId('pudl_event', [
			'event_lat' => $location['lat'],
			'event_lon' => $location['lon'],
		],'event_id', $event);
	}
}

if (empty($event['event_lat'])  ||  empty($event['event_lon'])) {
	$event['event_lat'] = 0;
	$event['event_lon'] = 0;
}




////////////////////////////////////////////////////////////////////////////////
//PULL TIMEZONE DATA
////////////////////////////////////////////////////////////////////////////////
if ((!empty($event['event_lat'])  ||  !empty($event['event_lon']))  &&  empty($event['event_timezone'])) {
	$timezone = \af\time::nearestZone($event['event_lat'], $event['event_lon']);
	if (!empty($timezone['timeZoneId'])) {
		$db->updateId('pudl_event', [
			'event_timezone' => $timezone['timeZoneId']
		], 'event_id', $event);

		$event['event_timezone'] = $timezone['timeZoneId'];
	}
}

if (!empty($event['event_timezone'])) {
	$timezone	= new DateTimeZone($event['event_timezone']);
	$offset		= $timezone->getOffset(new DateTime('now'));
	$event['localtime']	= date('g:i:s A', $af->time() + $offset);
	$event['timezone']	= round($offset / AF_HOUR);
} else {
	$event['timezone']	= 0;
}




////////////////////////////////////////////////////////////////////////////////
//COMMENTS
////////////////////////////////////////////////////////////////////////////////
$render['comment'] = $db->rows([
	'us' => _pudl_user(50),
	'cm' => 'pudl_comment',
], [
	'cm.commenter_id=us.user_id',
	'object_id'			=> $event['event_id'],
	'cm.object_type_id'	=> $af->type('event'),
	cpnFilterBanned(),
], 'comment_timestamp');

foreach ($render['comment'] as &$item) {
	$item['timesince'] = \af\time::since( $item['comment_timestamp'] );
} unset($item);
$afurl->cdnAll($render['comment'], 'img', 'thumb_hash');

$render['newcomm'] = ['type'=>'event', 'id'=>$event['event_id']];




////////////////////////////////////////////////////////////////////////////////
//PULL YOUTUBE DATA
////////////////////////////////////////////////////////////////////////////////
if (empty($event['event_youtube'])) {
	if ($user->hasAccessStaff('event', $event)) {
		$render['youtube'] = [
			'youtube_title' => 'No YouTube Video Selected',
		];
	} else {
		$render['youtube'] = [];
	}
} else {
	$render['youtube'] = $db->rowId(
		'pudl_youtube',
		'youtube_id',
		$event['event_youtube']
	);

	$render['youtube']['text'] = afString::linkify(
		$render['youtube']['youtube_description']
	);
}
