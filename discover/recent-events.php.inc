<?php

$rows = $db->cache(AF_HOUR)->group(
	//COLUMN
	[
		'id'	=> 'ev.event_id',
		'ev.event_name',
		'ev.event_start',
		'ev.event_end',
		'th.thumb_hash',
		'fl.file_width',
		'fl.file_height',
		'fl.file_average',
		'mime'	=> 'fl.mime_id',
		'total'	=> pudl::count(),
	],
	[
		'ev'	=>_pudl_event($thumb),
		'fl'	=> 'pudl_file',
		'ga'	=> 'pudl_gallery',
		'gi'	=> 'pudl_gallery_image',
	],
	[
		'ev.event_id=ga.event_id',
		'gi.gallery_id=ga.gallery_id',
		'th.file_hash=fl.file_hash',
		'ga.gallery_type'	=> 'gallery',
		['ev.event_start'	=> pudl::gt( \af\time::from(AF_MONTH*2, AF_HOUR) )],
		['ev.event_start'	=> pudl::lt( \af\time::from(0, AF_HOUR))],
	],
	'ev.event_id',
	['total'=>pudl::dsc()],
	50
)->complete();




if (empty($rows)) return;




$total	= 0;
foreach ($rows as $row) $total += $row['total'];
$value	= 997 / $total;
$count	= 1;


foreach ($rows as $item) {
	$events[] = (int) $item['id'];

	$rank			= ($count * $value) . 'e';
	$count			+= $item['total'];
	$data[$rank]	= $item + [
		'type'		=> 'event',
		'name'		=> $item['total'] . ' Photos',
		'img'		=> $afurl->cdn($item),
		'url'		=> 'event/' . $afurl->cleanl($item['event_name']) . '/photos',
		'icon'		=> 'convention.svg',
		'link_url'	=> 'event/' . $afurl->cleanl($item['event_name']),
		'link_name'	=> $item['event_name'],
		'width'		=> $af->discoverWidth($item),
		'class'		=> 'cpn-discover-event',
	];
}

unset($rows);
