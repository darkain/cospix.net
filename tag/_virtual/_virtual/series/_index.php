<?php

require_once('../tag.php.inc');


$af->title = "Series related to $af->title";




/////////////////////////////////////////////
// PULL ALL HEIRARCHICAL LABELS - CHARACTER
/////////////////////////////////////////////
$render['series'] = $db->rows(
	[
		'gr' => _pudl_group(200),
		'gt' => 'pudl_group_type',
		'gl' => 'pudl_group_label',
		'ge' => 'pudl_group_relate',
	],
	[
		[
			['ge.group_parent'	=> $group['group_id'], 'ge.group_child=gr.group_id'],
			['ge.group_child'	=> $group['group_id'], 'ge.group_parent=gr.group_id'],
		],
		'gt.group_type_name'	=> 'series',
		'gr.group_type_id=gt.group_type_id',
		'gl.group_id=gr.group_id',
	],
	'group_label'
);

$afurl->cdnAll($render['series'], 'img', 'thumb_hash');




/////////////////////////////////////////////
// RENDER ALL THE THINGS
/////////////////////////////////////////////
$afurl->jq = 'series/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq)->merge($render)->render();
} else {
	require('_index.php');
}
