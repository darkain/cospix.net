<?php

$id = $get->id();




/////////////////////////////////////////////
// QUERY
/////////////////////////////////////////////
$result = $db->group(
	['us.*', 'up.user_tagline', 'th.*'],
	[
		'gg' => 'pudl_gallery',
		'gx' => 'pudl_gallery_image',
		'gi' => 'pudl_gallery_image',
		'ga' => 'pudl_gallery',
		'us' => _pudl_user(100),
		'up' => 'pudl_user_profile',
	],
	[
		'gg.gallery_id' => $id,
		'gg.gallery_id=gx.gallery_id',
		'gx.file_hash=gi.file_hash',
		'gx.gallery_id!=gi.gallery_id',
		'gi.gallery_id=ga.gallery_id',
		'us.user_id=ga.user_id',
		'us.user_id!=gg.user_id',
		'up.user_id=us.user_id',
		cpnFilterBanned(),
	],
	'us.user_id',
	'us.user_name'
);

$rows = $result->rows();
$result->free();

$afurl->cdnAll($rows, 'img', 'thumb_hash');




/////////////////////////////////////////////
// RENDER
/////////////////////////////////////////////
$af->load('credits.tpl');
	$af->block('user', $rows);
$af->render();
