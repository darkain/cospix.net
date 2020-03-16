<?php

require_once('../tag.php.inc');

$af->title = "Cosplayers - $af->title";


$size		= 500;
$block		= 'item';




/////////////////////////////////////////////
// PULL COSPLAYERS
/////////////////////////////////////////////
if ($col === 'series_id' || $col === 'character_id' || $col === 'outfit_id') {
	$render[$block] = $db->group(
		[
			'us.*',
			'th.thumb_hash',
			'tx.file_width',
			'tx.file_height',
			'tx.mime_id',
			'up.user_tagline',
			'total' => pudl::_count('*')
		],
		[
			'us' => _pudl_user($size),
			'up' => 'pudl_user_profile',
			'ga' => 'pudl_gallery',
			'gl' => 'pudl_group_label',
			'gx' => 'pudl_gallery_label',
		], [
			'us.user_id=ga.user_id',
			'up.user_id=us.user_id',
			'gl.group_label_id=gx.group_label_id',
			'ga.gallery_id=gx.gallery_id',
			'ga.gallery_thumb'	=> pudl::neq(NULL),
			'gl.group_id'		=> $group['group_id'],
			cpnFilterBanned(),
		],
		'user_id',
		[
			'total' => pudl::dsc(),
			'user_name'
		]
	)->rows();


} else {
	$render[$block] = $db->group(
		[
			'us.*',
			'th.thumb_hash',
			'tx.file_width',
			'tx.file_height',
			'tx.mime_id',
			'up.user_tagline',
			'total' => pudl::_count('*')
		], [
			'us' => _pudl_user($size),
			'up' => 'pudl_user_profile',
			'ga' => 'pudl_gallery',
			'gl' => 'pudl_group_label',
			'ge' => 'pudl_group_relate',
		],
		[
			cpnFilterBanned(),
			'us.user_id=ga.user_id',
			'up.user_id=us.user_id',
			'ga.gallery_type'=>'costume',
			'series_id=gl.group_label_id',
			'ga.gallery_thumb' => pudl::neq(NULL),
			[
				[
					'gl.group_id=ge.group_parent',
					'ge.group_child' => $group['group_id'],
				],
				[
					'gl.group_id=ge.group_child',
					'ge.group_parent' => $group['group_id'],
				],
			]
		],
		'user_id',
		['total'=>pudl::dsc()]
	)->rows();
}


$render['more']['more'] = false;//isset($render['users'][$count]);
//unset($render['users'][$count]);
/*
$afurl->cdnAll($render['users'], 'img', 'thumb_hash');

foreach ($render['users'] as &$item) {
	if ($item['total'] == 1) {
		$item['types'] = $item['total'] . ' costume';
	} else if ($item['total'] > 1) {
		$item['types'] = $item['total'] . ' costumes';
	}
} unset($item);

$render['profile']['count'] = count($render['users']);
*/

$render[$block] = cpn_user::manage($db, $render[$block]);




/////////////////////////////////////////////
// RENDER ALL THE THINGS
/////////////////////////////////////////////
$afurl->jq	= '_cospix/cpn_orm.tpl';

if ($get->int('jq')) {
	$af->mergePage($afurl->jq, $render);
} else {
	require('_index.php');
}
