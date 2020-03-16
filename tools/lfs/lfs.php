<?php

$page = strtolower($get->string('page'));

switch ($page) {
	case 'photographers':
	case 'cosplayers':
	case 'videographers':
		$clause = ['lfs_iam' => substr($page,0,-1)];
		break;

	default:
		$clause = [];
}


$id = 1108;

$data = $db->rows(
	['us' => array_merge(_pudl_user(100),[
		['natural'	=> 'pudl_looking'],
		['natural'	=> 'pudl_user_profile'],
		['natural'	=> 'pudl_event'],
		['left'		=> 'pudl_location', 'using'=>'location_id'],
	])],
	$clause+['event_id'=>$id, 'lfs_hidden=0'],
	['lfs_timestamp'=>pudl::dsc()]
);


$af->renderBlock('lfs.tpl', 'lfs', $data);
