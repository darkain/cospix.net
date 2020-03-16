<?php

$user->requireLogin();

$hash = $get->hash();




////////////////////////////////////////////////////////////
//LOAD THE IMAGE
////////////////////////////////////////////////////////////
\af\affirm(404,
	$image = $db->row([
		'fu' => 'pudl_file_user',
		'fl' => _pudl_file(100)
	], [
		'fu.file_hash=fl.file_hash',
		'fu.file_hash'	=> pudl::unhex($hash),
		'fu.user_id'	=> $user['user_id'],
	])
);




$image['img'] = $afurl->cdn($image, 'thumb_hash');
$image['hash'] = $hash;



////////////////////////////////////////////////////////////
//PULL FOLLOWERS
////////////////////////////////////////////////////////////
$followers = $db->selectRows(
	'*',
	[
		'fw' => ['pudl_follow',
			['left'=>['fu'=>'pudl_file_user'], 'on'=>[
				'fu.file_hash' => pudl::unhex($hash),
				'fu.user_id=fw.user_id',
			]],
		],
		'us' => _pudl_user(50),
	],
	[
		cpnFilterBanned(),
		'us.user_id=fw.user_id',
		'fw.follow_id'	=> $user['user_id'],
//		'fw.user_id'	=> pudl::neq($user['user_id']),
	],
	'user_name'
);

$afurl->cdnAll($followers, 'img', 'thumb_hash');




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS
////////////////////////////////////////////////////////////
$af->load('credit.tpl');
	$af->field('image', $image);
	$af->block('follower', $followers);
$af->render();
