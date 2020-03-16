<?php

$user->requireLogin();


//Check if we have a featured image in the past week
$item = $db->row('pudl_feature', [
	'user_id'			=> $user['user_id'],
	'feature_timestamp'	=> pudl::gt( $db->time() - AF_WEEK ),
]);

if (!empty($item)) {
	return $af->render('already-featured.tpl');
}



//Pull gallery list!
$galleries = $db->rows(['ga' => _pudl_gallery(200)], [
	'ga.user_id' => $user['user_id'],
	'thumb_hash' => pudl::neq(NULL),
], [
	'ga.gallery_timestamp'=>pudl::dsc()
]);

$afurl->cdnAll($galleries, 'img', 'thumb_hash', 'mime_id');


$af->load('_index.tpl');
	$af->block('g', $galleries);
$af->render();
