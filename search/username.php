<?php
$user->requireLogin();

$term = $get->search('term');



//SEARCH USERS
$result = $db->select(
	[
		'id'	=> 'us.user_id',
		'name'	=> 'user_name',
		'img'	=> 'thumb_hash',
		'path'	=> 'user_url',
	],
	[
		'us' => _pudl_user(50),
		'uo' => 'pudl_user_profile'
	],
	[
		cpnFilterBanned(),
		'us.user_id=uo.user_id',
		['user_name'=>pudl::like($term), 'user_url'=>pudl::like($term)],
	],
	[
		'user_name' => pudl::notLikeRight($term),
		'us.user_id'
	],
	10
);


$rows = $result->rows();
$result->free();

foreach ($rows as $key => &$val) {
	$val['type'] = 'user';
//	$val['icon'] = 'icon-16 icon-person';

	if (!empty($val['img'])) {
		$val['img'] = $afurl->cdn($val['img']);
	} else {
		$val['img'] = $afurl->static.'/thumb2/profile.svg';
	}

	if (strlen($val['name']) > 40) {
		$val['name'] = substr($val['name'], 0, 40) . '...';
	}
} unset($val);

$af->json($rows);
