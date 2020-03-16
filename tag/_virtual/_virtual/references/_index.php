<?php

require_once('../tag.php.inc');

$af->title = "References - $af->title";




/////////////////////////////////////////////
// PULL REFERENCE GALLERIES
/////////////////////////////////////////////
$result = $db->group(
	['ga.*', 'th.*'],
	['ga' => _pudl_gallery(200)],
	[
		'ga.gallery_type'=>'gallery',
		'ga.group_id' => $group['group_id'],
	],
	'ga.gallery_id',
	'gallery_sort'
);

$render['g'] = $result->rows();
$result->free();

$afurl->cdnAll($render['g'], 'img', 'thumb_hash');




/////////////////////////////////////////////
//BUILD PROFILE DATA
/////////////////////////////////////////////
require('permission.php.inc');




/////////////////////////////////////////////
// RENDER ALL THE THINGS
/////////////////////////////////////////////
$afurl->jq = 'references/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq)->merge($render)->render();
} else {
	require('_index.php');
}
