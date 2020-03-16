<?php

$afurl->redirect($afurl->base.'/gallery');


/*
if (empty($type)) {
	$type	= 'gallery';
	$verb	= 'Galleries';
	$af->title	= 'Recently Created Cosplay Galleries';
}




////////////////////////////////////////////////////////////
//GALLERIES
////////////////////////////////////////////////////////////
$galleries = $db->cache(60)->group(
	[
		'us.user_id', 'us.user_name', 'us.user_url',
		'ga.gallery_name', 'ga.gallery_id', 'ga.gallery_timestamp',
		'ga.gallery_type',
		'th.thumb_hash',
	],
	[
		'ga' => _pudl_gallery(200),
		'us' => 'pudl_user',
		'gi' => 'pudl_gallery_image',
	],
	[
		'ga.user_id=us.user_id',
		'gi.gallery_id=ga.gallery_id',
		'ga.gallery_thumb'		=> pudl::neq(NULL),
		'ga.gallery_type'		=> $type,
		cpnFilterBanned(),
	],
	'ga.gallery_id',
	['ga.gallery_id'=>pudl::dsc()],
	108
)->complete();

$afurl->cdnAll($galleries, 'img', 'thumb_hash');




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////
$af->header();
	$af->load('gallery/newest.tpl');
		$af->field('type',	$type);
		$af->field('verb',	$verb);
		$af->block('g',		$galleries);
	$af->render();
$af->footer();
*/
