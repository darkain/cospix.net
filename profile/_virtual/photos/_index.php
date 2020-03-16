<?php


$af->title = 'Photos';


require_once('../profile.php.inc');

$block			= 'g';

if ($af->prometheus()) {
	$block		= 'item';
}




////////////////////////////////////////////////////////////////////////////////
//PAGING INFORMATION
////////////////////////////////////////////////////////////////////////////////
$offset = $get->int('from');
$clause = empty($offset) ? [] : ['user_time'=>pudl::lt($offset)];




////////////////////////////////////////////////////////////////////////////////
//USER INFORMATION
////////////////////////////////////////////////////////////////////////////////
if (!$user->is($profile)) {
	$clause[] = ['file_user_visible'=>1];
}




////////////////////////////////////////////////////////////////////////////////
//PULL IMAGE DATA
////////////////////////////////////////////////////////////////////////////////
$render[$block] = cpn_photo::collect($db, [
	'clause' => $clause,
], [
	'column' => [
		'fu.user_time',
		'ga.gallery_id',				'ga.gallery_name',
		'ga.gallery_type',
		'g_id'=>'ga2.gallery_id',		'g_name'=>'ga2.gallery_name',
		'g_type'=>'ga2.gallery_type',	'g_user'=>'ga2.user_id',
	],
	'table' => ['fu' => ['pudl_file_user',
		[
			//TODO: THIS IS A HACK THAT NEEDS REMOVING
			'hack'=>'cpnet_gallery_image JOIN cpnet_gallery AS ga using(gallery_id)',
			'using'=>['file_hash','user_id'],
		],
		['left'=>['gi2'=>'pudl_gallery_image'], 'using'=>['file_hash']],
		['left'=>['ga2'=>'pudl_gallery'], 'on'=>['gi2.gallery_id=ga2.gallery_id']],
	]],
	'clause' => [
		'fu.file_hash=fl.file_hash',
		'fu.user_id' => $profile->id(),
		[
			'ga.gallery_id'		=> pudl::neq(NULL),
			'ga2.gallery_id'	=> pudl::neq(NULL),
		]
	],
	'group' => ['file_hash'],
	'order' => ['user_time' => pudl::desc()],
	'limit'	=> 100
]);

foreach ($render[$block] as $file) {
	$file->user_id	= $profile->user_id;
	$file->user_url	= $profile->user_url;
}




////////////////////////////////////////////////////////////////////////////////
//PROCESS ALL THE THINGS
////////////////////////////////////////////////////////////////////////////////
$render['more'] = array('more' => isset($render[$block][100]) ? 1 : 0);
unset($render[$block][100]);




////////////////////////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS
////////////////////////////////////////////////////////////////////////////////
if (!$af->prometheus()) {
	if ($offset) {
		$afurl->jq = 'photos/list.tpl';
	} else {
		$afurl->jq = 'photos/_index.tpl';
	}
}

if ($get->int('jq')) {
	$render[$block]->prometheus();
	$af->load($afurl->jq);
		$af->field('user', $profile);
		$af->merge($render);
	$af->render();
} else {
	require('_index.php');
}
