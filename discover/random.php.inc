<?php

$rows = $db->cache(AF_DAY)->group(
	[
		'fl.*',
		'mime'	=> 'fl.mime_id',
		'th.thumb_hash',
		'us.user_name',
		'us.user_url',
		'us.user_id',
		'ga.gallery_id',
		'name'	=> 'ga.gallery_name',
	], [
		'fl' => _pudl_file($thumb),
		'gi' => '~ pudl_gallery_image(gi.file_hash=fl.file_hash)',
		'fm' => '< pudl_file_meta(fm.file_hash=fl.file_hash)',
		'ga' => '~ pudl_gallery(gallery_id)',
		'us' => '~ pudl_user(user_id)',
	], [
		cpnFilterBanned(),
		'fl.file_hash'		=> pudl::notInSet($images),
		'gi.gallery_id'		=> pudl::notInSet($galleries),
	],
	['fl.file_hash'],
	[pudl::rand()],
	1000
)->complete();




if (empty($rows)) return;




$total	= 1000;
//foreach ($rows as $row) $total += $row['views'];
$value	= 995 / $total;
$count	= 1;


foreach ($rows as $item) {
	$images[] = $item['file_hash'];

	//TODO: URLS ARE GETTING AN EXTRA / AT THE END, AND SHOULDNT BE!

	$rank			= ($count * $value) . 'i';
	$count			+= 1;
	$data[$rank]	= $item + [
		'url'		=> 'image/' . bin2hex($item['file_hash']) . '?gallery=' . $item['gallery_id'],
		'img'		=> $afurl->cdn($item),
		'icon'		=> 'image.svg',
		'width'		=> $af->discoverWidth($item),
	];
}

unset($rows);
