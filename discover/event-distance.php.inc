<?php

if (!$user->loggedIn()) return;

$profile['user_lat'] = (float) $profile['user_lat'];
$profile['user_lon'] = (float) $profile['user_lon'];


$distance = 200; //MILES
$lat = $distance/69;
$lon = $distance/abs(cos(deg2rad($profile['user_lat']))*69);


$rows = $db->cache(AF_HOUR)->having(
	//COLUMN
	[
		'id'	=> 'event_id',
		'event_name',
		'event_start',
		'event_end',
		'th.thumb_hash',
		'fl.file_width',
		'fl.file_height',
		'fl.file_average',
		'mime'	=> 'fl.mime_id',
		pudl::raw('(acos(sin(radians(event_lat)) * sin(radians(' . $profile['user_lat'] . ')) +
			cos(radians(event_lat)) * cos(radians(' . $profile['user_lat'] . ')) *
			cos(radians(event_lon) - radians(' . $profile['user_lon'] . '))) * 6378) AS distance'),
	],

	//TABLE
	[
		'ev' => _pudl_event($thumb),
		'fl' => 'pudl_file',
	],

	//CLAUSE
	[
		cpnFilterCanceled(),
		'th.file_hash=fl.file_hash',
		'event_start'	=> pudl::gt( \af\time::from(AF_MONTH*4, AF_HOUR) ),
		'event_lat'		=> pudl::between(
			$profile['user_lat']-$lat,
			$profile['user_lat']+$lat
		),
		'event_lon'		=> pudl::between(
			$profile['user_lon']-$lon,
			$profile['user_lon']+$lon
		),
		'event_id'		=> pudl::neq($events),
	],

	//HAVING
	['distance' => pudl::lt($distance)],

	//OREDER
	'distance',

	//LIMIT
	50
)->complete();




if (empty($rows)) return;




//$total	= 0;
//foreach ($rows as $row) $total += $row['distance'];
$total	= count($rows);
$value	= 999 / $total;
$count	= 1;


foreach ($rows as $item) {
	$events[] = (int) $item['id'];

	$rank			= ($count * $value) . 'l';
	$count			+= $item['distance'];
	$data[$rank]	= $item + [
		'type'		=> 'event',
		'name'		=> \af\time::daterange($item['event_start'], $item['event_end'], 'M'),
		'img'		=> $afurl->cdn($item),
		'url'		=> 'event/' . $afurl->clean($item['event_name']),
		'icon'		=> 'convention.svg',
		'link_url'	=> 'event/' . $afurl->clean($item['event_name']),
		'link_name'	=> $item['event_name'],
		'width'		=> $af->discoverWidth($item),
		'class'		=> 'cpn-discover-event',
	];
}

unset($rows);
