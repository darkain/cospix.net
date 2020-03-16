<?php


require_once('../tag.php.inc');


$af->title = "Episodes - $af->title";

$render = ['video' => $db->rows(
	[
		'yt' => 'pudl_youtube',
		'gv' => 'pudl_gallery_video',
		'ga' => 'pudl_gallery',
	],
	[
		'yt.youtube_id=gv.youtube_id',
		'gv.gallery_id=ga.gallery_id',
		'ga.group_id'		=> $group['group_id'],
		'ga.gallery_type'	=> 'video',
	],
	['gallery_sort', 'youtube_sort']
)];




/////////////////////////////////////////////
// RENDER ALL THE THINGS
/////////////////////////////////////////////
$afurl->jq = 'episodes/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq)->merge($render)->render();
} else {
	require('_index.php');
}
