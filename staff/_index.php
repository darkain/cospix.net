<?php

$af->title = "Contact Us";

$staff = $db->rows(
	['us'=>_pudl_user(100), 'up'=>'pudl_user_profile'],
	[
		'us.user_id=up.user_id',
		'user_permission'		=> 'admin',
//		'us.user_id IN (1,2,4,1888,370,2577,321,1941,1939,195,1892,1898,78,332,3616,4466)', //1885
	],
	['us.user_id!=2','user_name']
);

$afurl->cdnAll($staff, 'img', 'thumb_hash');

foreach ($staff as &$item) {
	$item['user_bio'] = afString::linkify($item['user_bio']);
} unset($item);


$af	->css('_index.css')
	->header()
		->renderBlock('_index.tpl', 'account', $staff)
	->footer();
