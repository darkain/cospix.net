<?php

$af->title = 'Gallery';
$og['description'] = 'Galleries from ';

require_once('../event.php.inc');

$render['gallery'] = &$event;

$render['more']['page'] = max($get->int('page'), 0);

$count = ($render['more']['page'] === 0) ? 99 : 100;

if ($af->prometheus()) {
	$block	= 'item';
	$size	= 500;
} else {
	$block	= 'g';
	$size	= 200;
}




////////////////////////////////////////////////////////////////////////////////
// PULL GALLERIES
////////////////////////////////////////////////////////////////////////////////
$render[$block] = new cpn_collection($db, 'cpn_gallery',
	$db->cache(60)->group(
		[
			'ga.*',
			'us.user_id',
			'us.user_name',
			'us.user_url',
			'th.thumb_hash',
			'th.file_hash',
			'fl.file_width',
			'fl.file_height',
		],
		[
			'ga' => _pudl_gallery($size),
			'gi' => 'pudl_gallery_image',
			'us' => 'pudl_user',
			'fl' => 'pudl_file',
		],
		[
			'fl.file_hash=th.file_hash',
			'ga.gallery_id=gi.gallery_id',
			'us.user_id=ga.user_id',
			'ga.event_id' => $event['event_id'],
			cpnFilterBanned(),
		],
		'ga.gallery_id',
		['gallery_timestamp'=>pudl::dsc()]
	)
);




////////////////////////////////////////////////////////////////////////////////
// PROCESS THINGS
////////////////////////////////////////////////////////////////////////////////
foreach ($render[$block] as $item) {
	$item->hash	= bin2hex($item->file_hash);
	$item->img	= $afurl->cdn( $item->thumb_hash );
} unset($item);




////////////////////////////////////////////////////////////////////////////////
// RENDER ALL THE THINGS
////////////////////////////////////////////////////////////////////////////////
$afurl->jq = 'gallery/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq);
		$af->field('event',		$event);
		$af->field('gallery',	$render['gallery']);
		$af->field('more',		$render['more']);
		$af->block('g',			$render['g']);
	$af->render();
} else {
	require('_index.php');
}
