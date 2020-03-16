<?php

$af->title = 'Photos';
$og['description'] = 'Photos from ';

require_once('../event.php.inc');

$render['gallery'] = &$event;

$render['more']['page'] = max($get->int('page'), 0);

$count = ($render['more']['page'] === 0) ? 99 : 100;



if ($af->prometheus()) {
	$block	= 'item';
} else {
	$block	= 'g';
}




////////////////////////////////////////////////////////////////////////////////
//PAGING INFORMATION
////////////////////////////////////////////////////////////////////////////////
$offset = $get->int('from');
$clause = empty($offset) ? [] : ['user_time'=>pudl::lt($offset)];




////////////////////////////////////////////////////////////////////////////////
//PULL IMAGE DATA
////////////////////////////////////////////////////////////////////////////////
$render[$block] = cpn_photo::collect($db, [
	'clause' => $clause,
], [
	'column' => [
		'ga.*',
		'us.*',
	],
	'table' => [
		'us' => 'pudl_user',
		'ga' => 'pudl_gallery',
		'gi' => 'pudl_gallery_image',
	],
	'clause' => [
		cpnFilterBanned(),
		'ga.event_id' => $event['event_id'],
		'gi.file_hash=fl.file_hash',
		'ga.gallery_id=gi.gallery_id',
		'ga.user_id=us.user_id',
	],
	'order' => ['image_time' => pudl::desc()],
	'limit'	=> 101,
]);

$render['more'] = [
	'more'	=> isset($render[$block][100]) ? 1 : 0,
	'page'	=> 1,
];
unset($render[$block][100]);

$render[$block]->galleryname();




////////////////////////////////////////////////////////////////////////////////
// PROCESS THINGS
////////////////////////////////////////////////////////////////////////////////
$render[$block]->header = ['template'=>'photos/header.tpl'];

foreach ($render[$block] as $item) {
	$item->img	= $afurl->cdn( $item->thumb_hash );
} unset($item);




////////////////////////////////////////////////////////////////////////////////
// RENDER ALL THE THINGS
////////////////////////////////////////////////////////////////////////////////
$afurl->jq = 'photos/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq);
		$af->field('event', $event);
		$af->merge($render);
	$af->render();
} else {
	require('_index.php');
}
