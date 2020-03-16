<?php

$result = $db->cache(AF_MINUTE*5)->group(
	[
		'type'	=> pudl::text('gallery'),
		'id'	=> 'ga.gallery_id',
		'name'	=> 'gallery_name',
		'gallery_type',
		'gallery_timestamp',
		'us.user_id',
		'us.user_url',
		'us.user_name',
		'th.thumb_hash',
		'fl.file_width',
		'fl.file_height',
		'fl.file_average',
		'mime'	=> 'fl.mime_id',
		'total'	=> pudl::count(),
	],
	[
		'ga'	=> _pudl_gallery($thumb),
		'fl'	=> 'pudl_file',
		'us'	=> 'pudl_user',
		'gi'	=> 'pudl_gallery_image',
	],
	[
		'th.file_hash=fl.file_hash',
		'ga.user_id=us.user_id',
		'gi.gallery_id=ga.gallery_id',
		'ga.gallery_name'		=> pudl::neq(NULL),
		'ga.gallery_thumb'		=> pudl::neq(NULL),
		'ga.gallery_timestamp'	=> pudl::gt( \af\time::from(AF_MONTH*3, AF_MINUTE*5) ),
	],
	'ga.gallery_id',
	['total'=>pudl::dsc()]
);


if (!$result->count()) return;


$value	= 996 / $result->count();
$count	= 1;


while ($item = $result()) {
	$galleries[]	= (int) $item['id'];

//	$item['name']	.= ' by ' . $item['user_name'];
	$item['name']	.= ' gallery';

	$rank			= (($count * $value)) . 'g';
	$data[$rank]	= $item + [
		'img'		=> $afurl->cdn($item),
		'url'		=> $afurl->user($item, $item['gallery_type'], $item['id']),
		'icon'		=> $item['gallery_type'] . '.svg',
		'width'		=> $af->discoverWidth($item),
	];

	$count++;
}

$result->free();
