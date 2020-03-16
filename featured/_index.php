<?php

$af->title = 'Photo of the Day';



////////////////////////////////////////////////////////////
//IMAGE LIST
////////////////////////////////////////////////////////////
$images = $db->group([
	'fs.*',
	'us.*',
	'th.thumb_hash',
	'tx.mime_id',
	'ga.gallery_id',
	'fv.vote_id',
], [
	'fs' => ['pudl_feature_submission',
		['left'=>['fv'=>'pudl_feature_vote'], 'on'=>[
			'fv.user_id' => $user['user_id'],
			'fs.submission_id=fv.submission_id'
		]]
	],
	'gi' => _pudl_gallery_image(200),
	'ga' => 'pudl_gallery',
	'us' => 'pudl_user',
], [
	cpnFilterBanned(),
	'fs.file_hash=gi.file_hash',
	'fs.user_id=ga.user_id',
	'us.user_id=ga.user_id',
	'gi.gallery_id=ga.gallery_id',
], 'us.user_id')->complete();

$afurl->cdnAll($images, 'img', 'thumb_hash', 'mime_id');

foreach ($images as &$item) {
	$item['hash'] = bin2hex($item['file_hash']);
} unset($item);


srand( floor($db->time() / (AF_MINUTE*5)) );
shuffle($images);




////////////////////////////////////////////////////////////
//RECENTLY FEATURED IMAGES
////////////////////////////////////////////////////////////
$recent = $db->group([
	'fe.*',
	'us.*',
	'th.thumb_hash',
	'tx.mime_id',
	'ga.gallery_id',
], [
	'fe' => 'pudl_feature',
	'gi' => _pudl_gallery_image(200),
	'ga' => 'pudl_gallery',
	'us' => 'pudl_user',
], [
	cpnFilterBanned(),
	'fe.file_hash=gi.file_hash',
	'fe.user_id=ga.user_id',
	'us.user_id=ga.user_id',
	'gi.gallery_id=ga.gallery_id',
],
	'fe.file_hash',
	['fe.feature_timestamp'=>pudl::dsc()],
	8
)->complete();

$afurl->cdnAll($recent, 'img', 'thumb_hash', 'mime_id');

foreach ($recent as &$item) {
	$item['hash'] = bin2hex($item['file_hash']);
} unset($item);




////////////////////////////////////////////////////////////
//MY SUBMISSION
////////////////////////////////////////////////////////////
$total = $db->countId('pudl_feature_vote', 'user_id', $user);

$mine = $db->selectRow([
	'gi.file_hash',
	'th.thumb_hash',
	'fl.mime_id',
], [
	'fs' => 'pudl_feature_submission',
	//YES, WE WANT EIGHT-HUNDRED SIZE FOR THIS PAGE
	'gi' => _pudl_gallery_image(800),
	'fl' => 'pudl_file',
	'ga' => 'pudl_gallery',
], [
	'fl.file_hash=gi.file_hash',
	'fs.file_hash=gi.file_hash',
	'fs.user_id=ga.user_id',
	'gi.gallery_id=ga.gallery_id',
	'fs.user_id' => $user['user_id'],
	//'fs.user_id' => 2
]);

if (!empty($mine)) {
	$mine['img']	= $afurl->cdn($mine, 'file_hash', 'mime_id');
	$mine['hash']	= bin2hex($mine['file_hash']);
}




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!!
////////////////////////////////////////////////////////////
$af->header();
	$af->load('_index.tpl');
		$af->field('total',		$total);
		$af->field('image',		$mine);
		$af->block('g',			$images);
		$af->block('recent',	$recent);
	$af->render();
$af->footer();
