<?php

$af->title = 'Universe Tags';


$size			= 200;
$template		= 'taglist.tpl';
$block			= 'tags';

if ($af->prometheus()) {
	$size		= 500;
	$template	= 'discover/_index.tpl';
	$block		= 'item';
}




////////////////////////////////////////////////////////////////////////////////
// PULL UNIVERSE TAGS
////////////////////////////////////////////////////////////////////////////////
$tags = $db->selectRows([
	'gl.*',
	'gr.*',
	'gt.*',
	'th.thumb_hash',
	'th.file_hash',
	'fl.file_width',
	'fl.file_height',
	'fl.mime_id',
], [
	'gl' => 'pudl_group_label',
	'gt' => 'pudl_group_type',
	'fl' => 'pudl_file',
	'gr' => _pudl_group($size),
], [
	'gt.group_type_name'	=> 'universe',
	'gl.group_id=gr.group_id',
	'gr.group_type_id=gt.group_type_id',
	'th.file_hash=fl.file_hash',
], 'group_label');

$afurl->cdnAll($tags, 'img', 'thumb_hash', 'mime_id');

foreach ($tags as &$item) {
	if (empty($item['img'])) {
		$item['img'] = $afurl->static . '/thumb2/universe.svg';
	}
} unset($item);




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
chdir('_virtual');

$af	->header()
		->load($template)
			->block($block,		$tags)
			->block('nttags',	[])
			->block('letters',	[])
		->render()
	->footer();
