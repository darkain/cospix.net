<?php

$size			= 200;
$template		= 'gallery/_index.tpl';
$block			= 'g';

if (empty($type)) {
	$type		= 'gallery';
	$verb		= 'Galleries';
	$af->title	= 'Cosplay Galleries';
}

if ($af->prometheus()) {
	$af->title	= 'Cosplay Galleries';
	$type		= ['gallery', 'costume'];
	$size		= 500;
	$template	= 'discover/_index.tpl';
	$block		= 'item';
}




////////////////////////////////////////////////////////////////////////////////
//GALLERIES
////////////////////////////////////////////////////////////////////////////////
$galleries = $db->cache(60)->group(
	[
		'us.user_id',		'us.user_name',		'us.user_url',
		'ga.gallery_name',	'ga.gallery_id',	'ga.gallery_timestamp',
		'ga.gallery_type',
		'th.thumb_hash',
		'fl.file_width',	'fl.file_height',	'fl.mime_id',	'fl.file_average',
	],
	[
		'ga' => _pudl_gallery($size),
		'fl' => 'pudl_file',
		'us' => 'pudl_user',
		'gi' => 'pudl_gallery_image',
	],
	[
		'th.file_hash=fl.file_hash',
		'ga.user_id=us.user_id',
		'gi.gallery_id=ga.gallery_id',
		'ga.gallery_type'		=> $type,
		'ga.gallery_thumb'		=> pudl::neq(NULL),
		'ga.gallery_timestamp'	=> pudl::gt( \af\time::from(AF_MONTH*12, 60) ),
		cpnFilterBanned(),
	],
	'ga.gallery_id',
	[
		'ga.gallery_timestamp'	=> pudl::dsc(),
		'ga.gallery_id'			=> pudl::dsc(),
	],
	108
)->complete();

$afurl->cdnAll($galleries, 'img', 'thumb_hash', 'mime_id');




////////////////////////////////////////////////////////////////////////////////
//CALCULATE WIDTH/HEIGHT RATIO
////////////////////////////////////////////////////////////////////////////////
foreach ($galleries as &$item) {
	$item['width']	= $af->discoverWidth($item);
	$item['name']	= $item['gallery_name'];

	$item['url']	= $afurl([
		empty($item['user_url']) ? $item['user_id'] : $item['user_url'],
		$item['gallery_type'],
		$item['gallery_id']
	]);
} unset($item);




////////////////////////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////////////////////////
$af->header();
	$af->load($template);
		$af->field('type',	is_array($type) ? reset($type) : $type);
		$af->field('verb',	is_array($verb) ? reset($verb) : $verb);
		$af->block($block,	$galleries);
	$af->render();
$af->footer();


/*
'file_meta_value' =>
	array (
		'COMPUTED' =>
		array (
			'html' => 'width="2346" height="2850"',
			'Width' => 2346,
			'Height' => 2850,
			'IsColor' => 1,
		),
		'FileName' => 'phpVupKYz',
		'FileSize' => 965505,
		'FileType' => 2,
		'MimeType' => 'image/jpeg',
		'FileDateTime' => 1445267122,
		'SectionsFound' => '',
	),
*/
