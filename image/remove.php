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




$image['img']  = $afurl->cdn($image, 'thumb_hash');
$image['hash'] = $hash;


//RENDER THE THINGS
$af->load('remove.tpl');
	$af->field('image', $image);
$af->render();
