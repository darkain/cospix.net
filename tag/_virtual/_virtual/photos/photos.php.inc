<?php


$size		= 500;
$block		= 'item';
$type		= ['gallery', 'costume'];
$afurl->jq	= 'profile/_virtual/galleries/_prometheus.tpl';




////////////////////////////////////////////////////////////////////////////////
//ALTAFORM DATA TYPE (PULL EARLY DUE TO PUDL UNION CONFLICTS)
////////////////////////////////////////////////////////////////////////////////
$type = $af->type('image');




////////////////////////////////////////////////////////////////////////////////
//A LIST OF COLUMNS TO PULL DOWN
////////////////////////////////////////////////////////////////////////////////
$columns	= [
	'us.user_id',
	'us.user_name',
	'us.user_url',
	'ga.gallery_id',
	'ga.gallery_name',
	'ga.gallery_type',
	'gi.file_hash',
	'gi.image_time',
	'th.thumb_hash',
	'fl.file_width',
	'fl.file_height',
	'fl.mime_id',
];




////////////////////////////////////////////////////////////////////////////////
// PULL IMAGES
////////////////////////////////////////////////////////////////////////////////
switch ($col) {
	case 'series_id':
	case 'character_id':
	case 'outfit_id':



		$db->unionStart();

			$db->select($columns, [
				'ga' => 'pudl_gallery',
				'gx' => 'pudl_gallery_label',
				'gl' => 'pudl_group_label',
				'us' => 'pudl_user',
				'fl' => 'pudl_file',
				'gi' => _pudl_gallery_image($size),
			], [
				'th.file_hash=fl.file_hash',
				'ga.user_id=us.user_id',
				'gi.gallery_id=ga.gallery_id',
				'ga.gallery_id=gx.gallery_id',
				'gl.group_label_id=gx.group_label_id',
				'gl.group_id'		=> $group['group_id'],
				cpnFilterBanned(),
			]);

			$db->select($columns, [
				'ga' => 'pudl_gallery',
				'gl' => 'pudl_group_label',
				'us' => 'pudl_user',
				'ol' => 'pudl_object_label',
				'fl' => 'pudl_file',
				'fu' => 'pudl_file_user',
				'gi' => _pudl_gallery_image($size),
			], [
				'fu.file_hash=fl.file_hash',
				'th.file_hash=fl.file_hash',
				'ol.file_hash=gi.file_hash',
				'ol.object_label_user=ga.user_id',
				'fu.user_id=us.user_id',
				'ga.user_id=us.user_id',
				'gi.gallery_id=ga.gallery_id',
				'ol.group_label_id=gl.group_label_id',
				'ol.object_type_id'	=> $type,
				'gl.group_id'		=> $group['group_id'],
				cpnFilterBanned(),
			]);

		$render[$block] = new cpn_collection($db, 'cpn_photo',
			$db->cache(60)->unionGroup(
				'file_hash',
				['image_time'=>pudl::dsc()],
				101,
				($group['page'] * 100)
			)
		);
	break;


	case 'universe_id':
		$render[$block] = cpn_photo::collect($db, [
			'column'	=> $columns,

			'table'		=> [
				'us'	=> 'pudl_user',
				'ga'	=> 'pudl_gallery',
				'gi'	=> 'pudl_gallery_image',
				'gx'	=> 'pudl_gallery_label',
				'gl'	=> 'pudl_group_label',
				'ge'	=> 'pudl_group_relate',
				'fu'	=> 'pudl_file_user',
			],

			'clause'	=> [
				'ga.gallery_id=gx.gallery_id',
				'gl.group_label_id=gx.group_label_id',
				'fu.file_hash=fl.file_hash',
				'fl.file_hash=gi.file_hash',
				'fu.user_id=us.user_id',
				'ga.user_id=us.user_id',
				'gi.gallery_id=ga.gallery_id',
				[
					[
						'gl.group_id=ge.group_parent',
						'ge.group_child' => $group['group_id'],
					],
					[
						'gl.group_id=ge.group_child',
						'ge.group_parent' => $group['group_id'],
					],
				],
				cpnFilterBanned(),
			],

			'order'		=> ['gallery_timestamp' => pudl::desc()],

			'limit'		=> 102,

			'offset'	=> $group['page'] * 101,
			//TODO: LIMIT AND INFINITE SCROLLER
		]);
	break;



	case 'camera_id':
	case 'lens_id':
	case 'software_id':
		$render[$block] = new cpn_collection($db, 'cpn_photo',
			$db->select(
				$columns,
				[
					'ga' => 'pudl_gallery',
					'ol' => 'pudl_object_label',
					'us' => 'pudl_user',
					'fu' => 'pudl_file_user',
					'fl' => 'pudl_file',
					'gi' => _pudl_gallery_image($size),
				], [
					'fu.file_hash=fl.file_hash',
					'th.file_hash=fl.file_hash',
					'ga.user_id=us.user_id',
					'fu.user_id=us.user_id',
					'gi.gallery_id=ga.gallery_id',
					'ol.file_hash=gi.file_hash',
					'ol.group_label_id'	=> $group['group_label_id'],
					'ol.object_type_id'	=> $type,
					cpnFilterBanned(),
				],
				['user_time' => pudl::desc()],
				102,
				$group['page'] * 101
			)
		);
	break;



	default:
		$render[$block] = [];
	break;
}




////////////////////////////////////////////////////////////////////////////////
//PROCESS RESULT
////////////////////////////////////////////////////////////////////////////////
$render['more']['more'] = isset($render[$block][$count]);
unset($render[$block][$count]);

$render[$block]->galleryname();




////////////////////////////////////////////////////////////////////////////////
//PROMETHEUS FORMATTING
////////////////////////////////////////////////////////////////////////////////
/*
if ($af->prometheus()) {
	foreach ($render[$block] as &$item) {
		$item['width']	= $af->discoverWidth($item);
		$item['name']	= $item['gallery_name'];

		$item['url']	= $afurl([
			'image',
			bin2hex($item['file_hash'])
		]) . '?gallery=' . $item['gallery_id'];
	} unset($item);
}
*/
