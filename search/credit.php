<?php

$user->requireLogin();


$hash = $get->hash('hash');
$term = $get->search('term');


$users = $db->selectRows(
	['us.*', 'th.thumb_hash', 'fu.user_time'],
	[
		'us' => _pudl_user(50)+[
			['left' => ['fu' => 'pudl_file_user'],'on' => [
				'fu.file_hash'=>pudl::unhex($hash), 'fu.user_id=us.user_id'
			]],
			['left' => ['fw' => 'pudl_follow'], 'on' => [
				'fw.follow_id'=>$user['user_id'], 'us.user_id=fw.user_id'
			]]
		],
	],
	[
		cpnFilterBanned(),
		'user_name' => pudl::like($term),
	],
	['fw.follow_id'=>NULL, 'user_name'],
	15
);

$afurl->cdnAll($users, 'img', 'thumb_hash');



$selected = explode(',', $get->string('selected'));
foreach ($users as &$item) {
	$item['selected'] = in_array($item['user_id'], $selected);
} unset($item);



$af->load('credit.tpl');
	$af->block('users', $users);
$af->render();
