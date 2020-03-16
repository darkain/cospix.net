<?php

$afurl->redirect($afurl->base.'/badge/34');


/*
if (empty($type)) {
	$type	= 'gallery';
	$verb	= 'Galleries';
	$af->title	= 'Photographers With The Most Cosplay Galleries';
}




////////////////////////////////////////////////////////////
//USER LIST
////////////////////////////////////////////////////////////
$users = $db->cache(AF_HOUR)->group(
	[
		'us.*',
		'up.*',
		'ga.*',
		'th.*',
		'total' => pudl::count('ga.user_id'),
	],
	[
		'ga' => 'pudl_gallery',
		'us' => _pudl_user(200),
		'up' => 'pudl_user_profile',
	],
	[
		'us.user_id=ga.user_id',
		'us.user_id=up.user_id',
		'ga.gallery_thumb'		=> pudl::neq(NULL),
		'ga.gallery_type'		=> $type,
		cpnFilterBanned(),
	],
	'ga.user_id',
	['total'=>pudl::dsc()],
	108
)->complete();

$afurl->cdnAll($users, 'img', 'thumb_hash');

foreach ($users as &$item) {
	$item['types'] = "$verb: $item[total]";
} unset($item);




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////
$af->header();
	$af->load('gallery/total.tpl');
		$af->field('type',	$type);
		$af->field('verb',	$verb);
		$af->block('users',	$users);
	$af->render();
$af->footer();
*/
