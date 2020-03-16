<?php

$user->requireLogin();

$hash = $get->hash();




////////////////////////////////////////////////////////////
//LOAD THE IMAGE
////////////////////////////////////////////////////////////
\af\affirm(404,
	$image = $db->row([
		'fu' => 'pudl_file_user',
		'fl' => _pudl_file(100)
	], [
		'fu.file_hash=fl.file_hash',
		'fu.file_hash'	=> pudl::unhex($hash),
		'fu.user_id'	=> $user['user_id'],
	])
);




$image['img']  = $afurl->cdn($image, 'thumb_hash');
$image['hash'] = $hash;




////////////////////////////////////////////////////////////
//LOAD USER'S COSTUMES
////////////////////////////////////////////////////////////
$costume = $db->selectRows(
	['ga.*', 'th.*', 'in_gallery'=>'gi.file_hash'],
	['ga' => array_merge(_pudl_gallery(50), [
		[
			'left' => ['gi' => 'pudl_gallery_image'],
			'clause' => [
				'gi.gallery_id=ga.gallery_id',
				'gi.file_hash' => pudl::unhex($hash),
			]
		]
	])],
	['ga.user_id'=>$user['user_id'], 'ga.gallery_type'=>'costume'],
	'ga.gallery_sort'
);

$afurl->cdnAll($costume, 'img', 'thumb_hash');

foreach ($costume as &$item) {
	$item['class'] = $item['in_gallery'] ? 'cpn-credit-add-selected' : '';
} unset($item);




////////////////////////////////////////////////////////////
//LOAD USER'S GALLERIES
////////////////////////////////////////////////////////////
$gallery = $db->selectRows(
	['ga.*', 'th.*', 'in_gallery'=>'gi.file_hash'],
	['ga' => array_merge(_pudl_gallery(50), [
		[
			'left' => ['gi' => 'pudl_gallery_image'],
			'clause' => [
				'gi.gallery_id=ga.gallery_id',
				'gi.file_hash' => pudl::unhex($hash),
			]
		]
	])],
	['ga.user_id'=>$user['user_id'], 'ga.gallery_type'=>'gallery'],
	'ga.gallery_sort'
);

$afurl->cdnAll($gallery, 'img', 'thumb_hash');

foreach ($gallery as &$item) {
	$item['class'] = $item['in_gallery'] ? 'cpn-credit-add-selected' : '';
} unset($item);




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS
////////////////////////////////////////////////////////////
$af->load('add.tpl');
	$af->field('image', $image);
	$af->block('costume', $costume);
	$af->block('gallery', $gallery);
$af->render();
