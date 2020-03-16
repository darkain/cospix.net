<?php

$af->title = 'Most Favorited Cosplay Photos';


$rows = $db->cache(AF_MINUTE*5)->group(
	[
		'xx.thumb_hash',
		'xx.file_comments',
		'gi.file_hash',
		'ga.gallery_id',
		'ga.gallery_name',
		'us.user_id',
		'us.user_name',
		'us.user_url',
	],
	[
		'xx' => $db->in()->select(
			['fl.*', 'th.thumb_hash'],
			['fl'=>_pudl_file(200)],
			false,
			['file_comments'=>pudl::dsc()],
			200
		),
		'gi' => 'pudl_gallery_image',
		'ga' => 'pudl_gallery',
		'us' => 'pudl_user',
	],
	[
		'xx.file_hash=gi.file_hash',
		'gi.gallery_id=ga.gallery_id',
		'ga.user_id=us.user_id',
	],
	'xx.file_hash',
	['xx.file_comments'=>pudl::dsc()],
	100
)->complete();



foreach ($rows as &$item) {
	$item['icon']	= 'image.svg';
	$item['name']	= $item['file_comments']. ' : ' . $item['gallery_name'];
	$item['url']	= $afurl(['image', bin2hex($item['file_hash'])]) . '?gallery=' . $item['gallery_id'];
	$item['img']	= $afurl->cdn($item);
} unset($item);


$af->header();
	$af->load('_cospix/discover_page.tpl');
		$af->block('item', $rows);
	$af->render();
$af->footer();

