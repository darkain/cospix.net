<?php
$afurl->redirect("$afurl->base/{$router->virtual[0]}");

chdir('..');

$af->title = 'Gear';


////////////////////////////////////////////////////////////
//PULL PROFILE DATA
////////////////////////////////////////////////////////////
if (empty($profile)) {
	$profile = $db->row('pudl_user', ['user_id'=>$router->id, cpnFilterBanned(0)]);
	if ($router->id === 0  ||  empty($profile)) \af\error(404);
}




////////////////////////////////////////////////////////////
//PULL GEAR - TAGS
////////////////////////////////////////////////////////////
//TODO: FIX ME!
$result = $db->group(
	['gr.*', 'gl.*', 'gt.*', 'th.thumb_hash'],
	[
		'gr' => _pudl_group(50),
		'gt' => 'pudl_group_type',
		'gl' => 'pudl_group_label',
		'ol' => 'pudl_object_label',
		'gi' => 'pudl_gallery_image',
		'ga' => 'pudl_gallery',
	],
	[
		'gt.group_type_id=gr.group_type_id',
		'gr.group_id=gl.group_id',
		'ol.group_label_id=gl.group_label_id',
		'gi.file_hash=ol.file_hash',
		'gi.gallery_id=ga.gallery_id',
		'ol.object_type_id'	=> $af->type('image'),
		'ga.gallery_type'	=> 'gallery',
		'ga.gallery_role'	=> 'photo',
		'ga.user_id'		=> $profile['user_id'],
	],
	'gr.group_id',
	['group_type_name', 'group_label']
);




////////////////////////////////////////////////////////////
//READ ALL THE THINGS
////////////////////////////////////////////////////////////
$render['tags'] = $result->rows();
$result->free();

$afurl->cdnAll($render['tags'], 'img', 'thumb_hash');




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS
////////////////////////////////////////////////////////////
if ($get->int('jq')) {
	$af->load('gear/_virtual.tpl');
	$af->field('profile',	$profile);
	$af->block('tags',		$render['tags']);
	$af->render();

} else {
	require('_virtual.php');
}
