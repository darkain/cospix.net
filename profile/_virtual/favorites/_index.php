<?php


$af->title = 'Favorites';


require_once('../profile.php.inc');


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
		'user_time' => 'favorite_timestamp',
	],
	'table' => [
		'fa' => 'pudl_favorite',
		'us' => 'pudl_user',
		'ga' => 'pudl_gallery',
	],
	'clause' => [
		cpnFilterBanned(),
		'fa.user_id' => $profile->user_id,
		'fa.file_hash=fl.file_hash',
		'ga.gallery_id=fa.gallery_id',
		'ga.user_id=us.user_id',
	],
	'order' => ['favorite_timestamp' => pudl::desc()],
	'limit'	=> 101
]);

$render['more'] = ['more' => isset($render[$block][100]) ? 1 : 0];
unset($render[$block][100]);

$render[$block]->galleryname();




////////////////////////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS
////////////////////////////////////////////////////////////////////////////////
if ($offset) {
	$afurl->jq = 'favorites/list.tpl';
} else {
	$afurl->jq = 'favorites/_index.tpl';
}

if ($get->int('jq')) {
	$af->load($afurl->jq);
		$af->field('user', $profile);
		$af->merge($render);
	$af->render();
} else {
	require('_index.php');
}
