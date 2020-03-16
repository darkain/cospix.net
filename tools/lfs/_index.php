<?php

$af->title = 'Looking For Shoots';
$afurl->af_host = 'm.cospix.net';

\af\device::set('mobile');

$id = 1108;

$data = $db->rows(
	['us' => array_merge(_pudl_user(100),[
		['natural'	=> 'pudl_looking'],
		['natural'	=> 'pudl_user_profile'],
		['natural'	=> 'pudl_event'],
		['left'		=> 'pudl_location', 'using'=>'location_id'],
	])],
	['event_id'=>$id, 'lfs_hidden=0'],
	['lfs_timestamp'=>pudl::dsc()]
);


$af->header();
	$af->load('_index.tpl');
		$af->block('lfs', $data);
	$af->render();
$af->footer();
