<?php

require_once('../tag.php.inc');

$af->title = "Costumes - $af->title";


$block	= 'item';
$size	= 500;


/////////////////////////////////////////////
// PULL COSTUMES
/////////////////////////////////////////////
if ($col === 'series_id' || $col === 'character_id' || $col === 'outfit_id') {

	$render[$block] = new cpn_collection($db, 'cpn_gallery',
		$db->group(
			[
				'us.*', 'ga.*', 'th.*',
				'tx.file_width',
				'tx.file_height',
				'tx.mime_id',
			],
			[
				'ga' => _pudl_gallery($size),
				'gx' => 'pudl_gallery_label',
				'us' => 'pudl_user',
				'gl' => 'pudl_group_label',
			],
			[
				'us.user_id=ga.user_id',
				'ga.gallery_id=gx.gallery_id',
				'gl.group_label_id=gx.group_label_id',
				'ga.gallery_thumb'	=> pudl::neq(NULL),
				'gl.group_id'		=> $group['group_id'],
				cpnFilterBanned(),
			],
			'ga.gallery_id',
			[
				'ga.gallery_timestamp'	=> pudl::desc(),
				'ga.gallery_id'			=> pudl::desc(),
			],
			60
		)
	);


} else {


	$render[$block] = new cpn_collection($db, 'cpn_gallery',
		$db->group(
			[
				'us.*', 'ga.*', 'th.*',
				'tx.file_width',
				'tx.file_height',
				'tx.mime_id',
			],
			[
				'ga' => _pudl_gallery($size),
				'gx' => 'pudl_gallery_label',
				'us' => 'pudl_user',
				'gl' => 'pudl_group_label',
				'ge' => 'pudl_group_relate',
			],
			[
				cpnFilterBanned(),
				'us.user_id=ga.user_id',
				'ga.gallery_id=gx.gallery_id',
				'gl.group_label_id=gx.group_label_id',
				'ga.gallery_thumb'	=> pudl::neq(NULL),
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
			'ga.gallery_id',
			[
				'ga.gallery_timestamp'	=> pudl::desc(),
				'ga.gallery_id'			=> pudl::desc(),
			],
			60
		)
	);

}

//$render['g'] = $result->rows();
//$result->free();

//$afurl->cdnAll($render['g'], 'img', 'thumb_hash');




/////////////////////////////////////////////
// RENDER ALL THE THINGS
/////////////////////////////////////////////
$afurl->jq = 'costumes/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq)->merge($render)->render();
} else {
	require('_index.php');
}
