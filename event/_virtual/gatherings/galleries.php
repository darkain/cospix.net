<?php

$render = ['gathering' => $db->rowId('pudl_gathering', 'gathering_id', $get->id())];
\af\affirm(404, $render['gathering']);




////////////////////////////////////////////////////////////
//GALLERIES
////////////////////////////////////////////////////////////
$result = $db->group('*', [
	'ga' => _pudl_gallery(200),
	'us' => 'pudl_user',
	'gi' => 'pudl_gallery_image',
], [
	'ga.user_id=us.user_id',
	'gi.gallery_id=ga.gallery_id',
	'ga.gallery_thumb'		=> pudl::neq(NULL),
	'ga.gallery_type'		=> 'gallery',
	'ga.gathering_id'		=> $get->id(),
	cpnFilterBanned(),
],
	'ga.gallery_id',
[
	'ga.gallery_timestamp'	=> pudl::dsc(),
	'ga.gallery_id'			=> pudl::dsc(),
]);

$galleries = $result->rows();
$result->free();

$afurl->cdnAll($galleries, 'img', 'thumb_hash');




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////
$af->load('galleries.tpl');
	$af->block('g', $galleries);
$af->render();
