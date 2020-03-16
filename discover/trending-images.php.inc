<?php

$rows = $db->cache(AF_MINUTE*5)->group(
	[
		'xx.*',
		'us.user_name',
		'us.user_url',
		'us.user_id',
		'ga.gallery_id',
		'name'	=> 'ga.gallery_name',
	], [
		'xx' => $db->in()->groupHaving(
			[
				'fl.*',
				'mime'	=> 'fl.mime_id',
				'th.thumb_hash',
				'views'	=> pudl::count()
			], [
				'fl' => _pudl_file($thumb),
				'pv' => 'pudl_pageview',
			], [
				'fl.file_hash=pv.file_hash',
				'fl.file_views'		=> pudl::gt(9),
				'pv.view_timestamp'	=> pudl::gt( \af\time::from(AF_MONTH, AF_MINUTE*5) ),
				'fl.file_hash'		=> pudl::notInSet($images),
			],
			'fl.file_hash',
			['views' => pudl::gt(2)],
			['views' => pudl::dsc()],
			1000
		),
		'gi' => ['pudl_gallery_image',
			['left'=>'pudl_file_meta', 'using'=>'file_hash']
		],
		'ga' => 'pudl_gallery',
		'us' => 'pudl_user',
	],
	[
		cpnFilterBanned(),
		'xx.file_hash=gi.file_hash',
		'gi.gallery_id=ga.gallery_id',
		'ga.user_id=us.user_id',
		'gi.gallery_id'		=> pudl::notInSet($galleries),
	],
	['xx.file_hash'],
	['views' => pudl::dsc()]
)->complete();




if (empty($rows)) return;




$total	= 0;
foreach ($rows as $row) $total += $row['views'];
$value	= 995 / $total;
$count	= 1;


foreach ($rows as $item) {
	$images[] = $item['file_hash'];

	//TODO: URLS ARE GETTING AN EXTRA / AT THE END, AND SHOULDNT BE!

	$rank			= ($count * $value) . 'i';
	$count			+= $item['views'];
	$data[$rank]	= $item + [
		'url'		=> 'image/' . bin2hex($item['file_hash']) . '?gallery=' . $item['gallery_id'],
		'img'		=> $afurl->cdn($item),
		'icon'		=> 'image.svg',
		'width'		=> $af->discoverWidth($item),
	];
}

unset($rows);
