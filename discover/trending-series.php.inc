<?php

$type	= $af->type('gallery');

$rows	= $db->cache(AF_HOUR)->orderGroupEx(
	[
		'type'		=> pudl::text('tag'),
		'typename'	=> 'gt.group_type_name',
		'name'		=> 'gl.group_label',
		'id'		=> 'gl.group_label_id',
		'gr.group_id',
		'th.thumb_hash',
		'fl.file_width',
		'fl.file_height',
		'fl.file_average',
		'mime'		=> 'fl.mime_id',
		'total'		=> pudl::count(),
	],
	[
		'fl' => 'pudl_file',
		'ol' => 'pudl_object_label',
		'ga' => 'pudl_gallery',
		'gl' => 'pudl_group_label',
		'gt' => 'pudl_group_type',
		'gr' => _pudl_group($thumb),
	],
	[
		'gl.group_id=gr.group_id',
		'gr.group_type_id=gt.group_type_id',
		'ga.gallery_id=ol.object_id',
		'gl.group_label_id=ol.group_label_id',
		'th.file_hash=fl.file_hash',
		'gt.group_type_name'	=> ['series', 'character'],
		'ol.object_type_id'		=> $type,
		'ga.gallery_timestamp'	=> pudl::gt( \af\time::from(AF_MONTH*2, AF_HOUR) ),
		'th.thumb_hash'			=> pudl::neq(NULL),
	],
	['ga.gallery_id', 'group_type_name'],
	'id',
	['total'=>pudl::dsc()],
	50
)->complete();




if (empty($rows)) return;




$total	= 0;
foreach ($rows as $row) $total += $row['total'];
$value	= 994 / $total;
$count	= 1;


foreach ($rows as $item) {
	$tags[]			=  $item['group_id'];
	$rank			= ($count * $value) . 's';
	$count			+= $item['total'];
	$data[$rank]	=  $item + [
		'icon'		=> $item['typename'] . '.svg',
		'img'		=> $afurl->cdn($item),

		'url'		=> $item['type']	. '/' . $afurl->clean($item['typename'])
										. '/' . $afurl->clean($item['name']),

		'width'		=> $af->discoverWidth($item),
		'class'		=> 'cpn-discover-tag',
	];
}

unset($rows);
