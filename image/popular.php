<?php

$af->title = 'Popular Cosplay Photos';

/*
//TODO:
Now that all this subquery magic is built out... destroy it
Separate this out into two queries. The first pulls the list
of top favorites (cached), the second pulls all the data
associated with those items (uncached), this way we have
live an accurate view/fav/tag counts
*/

$rows = $db->cache(AF_MINUTE*5)->group(
	[
		'xx.thumb_hash',
		'gi.file_hash',
		'ga.gallery_id',
		'ga.gallery_name',
		'us.user_id',
		'us.user_name',
		'us.user_url',
	],
	[
		'xx' => $db->in()->group(
			['fl.*', 'th.thumb_hash', 'views' => pudl::count()],
			['fl'=>_pudl_file(200), 'pv'=>'pudl_pageview'],
			[
				'fl.file_hash=pv.file_hash',
				'view_timestamp' => pudl::gt( \af\time::from(AF_DAY, AF_MINUTE*5) ),
			],
			'fl.file_hash',
			['views'=>pudl::dsc()],
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
	['views'=>pudl::dsc()],
	100
)->complete();


foreach ($rows as &$item) {
	$item['icon']	= 'image.svg';
	$item['name']	= $item['gallery_name'];
	$item['url']	= $afurl(['image', bin2hex($item['file_hash'])]) . '?gallery=' . $item['gallery_id'];
	$item['img']	= $afurl->cdn($item);
} unset($item);


$af->header();
	$af->load('_cospix/discover_page.tpl');
		$af->block('item', $rows);
	$af->render();
$af->footer();
