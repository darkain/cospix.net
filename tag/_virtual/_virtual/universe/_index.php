<?php

require_once('../tag.php.inc');

$af->title = "Universe - $af->title";




/////////////////////////////////////////////
// PULL ALL HEIRARCHICAL LABELS - UNIVERSE
/////////////////////////////////////////////
$render['universe'] = $db->group(
	[
		'th.thumb_hash',
		'gt.*',
		'gl.*',
		'universe' => 'ul.group_label',
	],
	[
		'ur' => 'pudl_group_relate',
		'ug' => 'pudl_group',
		'ul' => 'pudl_group_label',
		'ut' => 'pudl_group_type',

		'ge' => 'pudl_group_relate',
		'gr' => _pudl_group(200),
		'gl' => 'pudl_group_label',
		'gt' => 'pudl_group_type',
	],
	[
		'ut.group_type_name'	=> 'universe',
		'ur.group_parent'		=> $group['group_id'],
		'ur.group_child=ug.group_id',
		'ug.group_id=ul.group_id',
		'ug.group_type_id=ut.group_type_id',

		'ge.group_child=ug.group_id',
		'ge.group_parent=gr.group_id',
		'gr.group_id=gl.group_id',
		'gr.group_type_id=gt.group_type_id',
		'gt.group_type_name'	=> 'series',
	],
	'gr.group_id',
	'group_label'
)->complete();


$afurl->cdnAll($render['universe'], 'img', 'thumb_hash');




/////////////////////////////////////////////
// RENDER ALL THE THINGS
/////////////////////////////////////////////
$afurl->jq = 'universe/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq)->merge($render)->render();
} else {
	require('_index.php');
}
