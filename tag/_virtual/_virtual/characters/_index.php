<?php

require_once('../tag.php.inc');


$af->title = "Characters from $af->title";




/////////////////////////////////////////////
// PULL ALL HEIRARCHICAL LABELS - CHARACTER
/////////////////////////////////////////////
$character = empty($group['group_display']) ? 'character' : 'character2';
$render['character'] = $render['character2'] = [];

$render[$character] = $db->rows(
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
		'gt.group_type_name'	=> 'character',
		'gr.group_type_id=gt.group_type_id',
		'gl.group_id=gr.group_id',
	],
	'group_label'
);

$afurl->cdnAll($render[$character], 'img', 'thumb_hash');
$group['character_count'] = $user->isStaff() ? 1 : count($render[$character]);

$characters = [];
foreach ($render[$character] as &$item) {
	$characters[$item['group_label_id']] = $item['group_label'];
} unset($item);




/////////////////////////////////////////////
// RECOMMENDED TAGS
/////////////////////////////////////////////
$render['recommend'] = [];
if ($user->isStaff()  &&  $group['group_type_name'] === 'series') {
	$clause = [];
	if (!empty($characters)) {
		$clause['gl.group_label_id'] = pudl::neq(array_flip($characters));
	}
	$result = $db->group(
		['gl.*', 'gr.*', 'thumb_hash', 'gt.group_type_name'],
		[
			'ga'	=> 'pudl_gallery',
			'gr'	=> _pudl_group(50),
			'gt'	=> 'pudl_group_type',
			'gl'	=> 'pudl_group_label',
			'ol'	=> 'pudl_object_label',
			'grx'	=> 'pudl_group',
			'gtx'	=> 'pudl_group_type',
			'glx'	=> 'pudl_group_label',
			'olx'	=> 'pudl_object_label',
		],
		$clause+[
			'ga.gallery_id=ol.object_id',
			'ol.group_label_id=gl.group_label_id',
			'gr.group_id=gl.group_id',
			'gr.group_type_id=gt.group_type_id',
			'gt.group_type_name'	=> 'character',

			'ga.gallery_id=olx.object_id',
			'olx.group_label_id=glx.group_label_id',
			'grx.group_id=glx.group_id',
			'grx.group_type_id=gtx.group_type_id',
			'gtx.group_type_name'	=> 'series',
			'glx.group_label_id'	=> $group['group_label_id'],
		],
		'gl.group_label_id',
		'gl.group_label'
	);

	$render['recommend'] = $result->rows();
	$result->free();

	$afurl->cdnAll($render['recommend'], 'img', 'thumb_hash');
}




/////////////////////////////////////////////
// RENDER ALL THE THINGS
/////////////////////////////////////////////
$afurl->jq = 'characters/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq)->merge($render)->render();
} else {
	require('_index.php');
}
