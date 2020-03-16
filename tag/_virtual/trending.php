<?php

$namespace = $db->rowId('pudl_group_type', 'group_type_name', $router->virtual[0]);
\af\affirm(404, $namespace);


$af->title = 'Trending ' . ucwords($router->virtual[0]) . ' Tags';


$size			= 200;
$template		= 'trending.tpl';
$block			= 'tags';

if ($af->prometheus()) {
	$size		= 500;
	$template	= 'discover/_index.tpl';
	$block		= 'item';
}




////////////////////////////////////////////////////////////////////////////////
// TIME FRAME
////////////////////////////////////////////////////////////////////////////////
$offset = AF_WEEK;
/*
switch ($get->int('time')) {
	case 24: $offset = AF_DAY;		$af->title .= ' for 1 Day';   break;
	case 7:  $offset = AF_WEEK;		$af->title .= ' for 1 Week';  break;
	case 30: $offset = AF_MONTH;	$af->title .= ' for 1 Month'; break;
	default: $offset = AF_WEEK*2;	$af->title .= ' for 2 Weeks'; break;
}
*/




////////////////////////////////////////////////////////////////////////////////
// PULL THE TAGS
////////////////////////////////////////////////////////////////////////////////
$type = $af->type('gallery');

$tags = $db->cache(AF_MINUTE)->orderGroupEx(
	[
		'gl.*',
		'group_type_name',
		'gallery_timestamp',
		'th.thumb_hash',
		'th.file_hash',
		'fl.file_width',
		'fl.file_height',
		'fl.mime_id',
		'count' => pudl::count(),
	], [
		'ol' => 'pudl_object_label',
		'ga' => 'pudl_gallery',
		'gl' => 'pudl_group_label',
		'gt' => 'pudl_group_type',
		'fl' => 'pudl_file',
		'gr' => _pudl_group($size),
	], [
		'th.file_hash=fl.file_hash',
		'gl.group_id=gr.group_id',
		'gr.group_type_id=gt.group_type_id',
		'ga.gallery_id=ol.object_id',
		'gl.group_label_id=ol.group_label_id',
		'gt.group_type_name'	=> $router->virtual[0],
		'ol.object_type_id'		=> $type,
		'ga.gallery_timestamp'	=> pudl::gt( \af\time::from($offset, AF_HOUR) ),
	],
	'ga.gallery_id',
	'group_label_id',
	[
		'thumb_hash'		=> NULL,
		'count'				=> pudl::dsc(),
		'gallery_timestamp'	=> pudl::dsc(),
	],
	100
)->complete();

$afurl->cdnAll($tags, 'img', 'thumb_hash', 'mime_id');




////////////////////////////////////////////////////////////////////////////////
//CALCULATE WIDTH/HEIGHT RATIO
////////////////////////////////////////////////////////////////////////////////
foreach ($tags as &$item) {
	$item['width']	= $af->discoverWidth($item);
	$item['name']	= $item['group_label'];

	$item['url']	= $afurl([
		'tag',
		$item['group_type_name'],
		$item['group_label'],
	]);
} unset($item);




////////////////////////////////////////////////////////////////////////////////
// RENDER ALL THE THINGS
////////////////////////////////////////////////////////////////////////////////
$af	->header()
		->load($template)
			->block($block, $tags)
		->render()
	->footer();
