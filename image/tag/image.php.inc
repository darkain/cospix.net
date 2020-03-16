<?php

$user->requireLogin();

$hash = $get->hash();




////////////////////////////////////////////////////////////
//PULL image DATA
////////////////////////////////////////////////////////////
$image = $db->row([
	'fl'=>_pudl_file(100),
	'fu'=>'pudl_file_user'
], [
	'fl.file_hash=fu.file_hash',
	'fl.file_hash'	=> pudl::unhex($hash),
	'fu.user_id'	=> $user['user_id'],
]);

\af\affirm(404, $image);

$image['img'] = $afurl->cdn($image, 'thumb_hash');
$image['hash'] = $hash;
