<?php

require_once('../tag.php.inc');

$af->title = "Cameras Used With $af->title";




/////////////////////////////////////////////
// PULL TAGS
/////////////////////////////////////////////
$result = $db->group(
	['gl.*', 'gt.*', 'th.thumb_hash'],
	[
		'ol1'	=> 'pudl_object_label',
		'ol2'	=> 'pudl_object_label',
		'gl'	=> 'pudl_group_label',
		'gr'	=> _pudl_group(50),
		'gt'	=> 'pudl_group_type',
	],
	[
		'ol1.group_label_id'	=> $group['group_label_id'],
		'ol1.object_type_id'	=> $af->type('image'),
		'ol2.object_type_id'	=> $af->type('image'),
		'gt.group_type_name'	=> 'camera',
		'ol1.file_hash=ol2.file_hash',
		'gl.group_label_id=ol2.group_label_id',
		'gr.group_id=gl.group_id',
		'gt.group_type_id=gr.group_type_id',
	],
	'gl.group_label_id',
	'gl.group_label'
);

$render['tags'] = $result->rows();
$result->free();

$afurl->cdnAll($render['tags'], 'img', 'thumb_hash');




/////////////////////////////////////////////
// RENDER ALL THE THINGS
/////////////////////////////////////////////
$afurl->jq = 'camera/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq)->merge($render)->render();
} else {
	require('_index.php');
}
