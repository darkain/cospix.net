<?php

$user->requireLogin();

$hash = $get->hash('id', true);




////////////////////////////////////////////////////////////
//CHECK IF THIS IMAGE HAS EVER BEEN FEATURED BEFORE
////////////////////////////////////////////////////////////
$featured = $db->rowId('pudl_feature', 'file_hash', $hash);
if (!empty($featured)) {
	return $af->render('featured.tpl');
}




////////////////////////////////////////////////////////////
//CHECK IF THIS IMAGE IS ALREADY IN THE SUBMISSION POOL
////////////////////////////////////////////////////////////
$submitted = $db->rowId('pudl_feature_submission', 'file_hash', $hash);
if (!empty($submitted)) {
	return $af->render('submitted.tpl');
}




////////////////////////////////////////////////////////////
//VERIFY WE HAVE THIS IMAGE IN ONE OF OUR GALLERIES
////////////////////////////////////////////////////////////
\af\affirm(404, $image = $db->selectRow(
	[
		'th.thumb_hash',
		'gi.file_hash',
		'fl.mime_id',
	], [
		'ga' => 'pudl_gallery',
		'gi' => _pudl_gallery_image(800),
		'fl' => 'pudl_file',
	], [
		'gi.file_hash=fl.file_hash',
		'ga.gallery_id=gi.gallery_id',
		'gi.file_hash'	=> $hash,
		'ga.user_id'	=> $user['user_id'],
	]
));

$image['img']	= $afurl->cdn($image, 'thumb_hash', 'mime_id');
$image['hash']	= bin2hex($image['file_hash']);

$af->renderField('image.tpl', 'image', $image);
