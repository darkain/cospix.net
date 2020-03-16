<?php

require_once('../tag.php.inc');

$af->title = "Users - $af->title";


$block	= $af->prometheus() ? 'item' : 'account';
$size	= $af->prometheus() ? 500 : 200;




////////////////////////////////////////////////////////////////////////////////
// PULL USERS
////////////////////////////////////////////////////////////////////////////////
$render[$block] = new cpn_collection($db, 'cpn_user',
	$db->group(
		[
			'us.*',
			'up.user_tagline',
			'th.thumb_hash',
			'fl.file_width',
			'fl.file_height',
			'fl.mime_id',
		],
		[
			'ol' => 'pudl_object_label',
			'gi' => 'pudl_gallery_image',
			'ga' => 'pudl_gallery',
			'us' => _pudl_user($size),
			'up' => 'pudl_user_profile',
			'fl' => 'pudl_file',
		],
		[
			cpnFilterBanned(),
			'fl.file_hash=th.file_hash',
			'gi.file_hash=ol.file_hash',
			'gi.gallery_id=ga.gallery_id',
			'us.user_id=ga.user_id',
			'us.user_id=up.user_id',
			'ga.gallery_type'	=> 'gallery',
			'ga.gallery_role'	=> 'photo',
			'ol.group_label_id'	=> $group['group_label_id'],
			'ol.object_type_id'	=> $af->type('image'),
		],
		'us.user_id'
	)
);




////////////////////////////////////////////////////////////////////////////////
// RENDER ALL THE THINGS
////////////////////////////////////////////////////////////////////////////////
$afurl->jq = 'users/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq)->merge($render)->render();
} else {
	require('_index.php');
}
