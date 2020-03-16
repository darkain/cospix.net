<?php

require_once('../tag.php.inc');


/////////////////////////////////////////////
// PULL THE GALLERY INFORMATION
/////////////////////////////////////////////
$render = ['gallery' => $db->selectRow(
	['ga.*', 'th.*'],
	['ga' => _pudl_gallery(200)],
	['gallery_id'=>$group['page_id'], 'group_id'=>$group['group_id']]
)];
\af\affirm(404, $render['gallery']);

$af->title = $render['gallery']['gallery_name'] . " - $af->title";




/////////////////////////////////////////////
// GALLERY
/////////////////////////////////////////////
$render['g'] = $db->selectRows(
	['th.*', 'gi.*', 'tx.file_credits', 'tx.file_comments', 'tx.file_favorites', 'tx.file_views'],
	['gi' => _pudl_gallery_image(200)],
	['gallery_id'=>$group['page_id'], 'gi.file_hash=th.file_hash'],
	['image_sort', 'image_time'=>pudl::dsc()]
);

foreach ($render['g'] as &$item) {
	$item['hash'] = bin2hex($item['file_hash']);
	if (!$item['file_comments'])	$item['file_comments']	= false;
	if (!$item['file_credits'])		$item['file_credits']	= false;
	if (!$item['file_favorites'])	$item['file_favorites']	= false;
	if (!$item['file_views'])		$item['file_views']		= false;
} unset($item);
$afurl->cdnAll($render['g'], 'img', 'thumb_hash', 'mime_id');




/////////////////////////////////////////////
// RENDER ALL THE THINGS
/////////////////////////////////////////////
$afurl->jq = 'references/_virtual.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq)->merge($render)->render();
} else {
	require('_index.php');
}
