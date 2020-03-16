<?php
$user->requireLogin();


$gallery = $db->rowId('pudl_gallery', 'gallery_id', $get->id('galleryid'));
\af\affirm(404, $gallery, 'Invalid Gallery');
\af\affirm(401, $user->is($gallery));


$gathering = $db->rowId('pudl_gathering', 'gathering_id', $get->id('gatheringid'));
\af\affirm(404, $gathering, 'Invalid Gathering');


if (!$db->clauseExists('pudl_user_gathering', [
	'user_id'		=> $user['user_id'],
	'gathering_id'	=> $gathering['gathering_id']
])) \af\error(401);


$db->insert('pudl_gallery_gathering', [
	'gallery_id'	=> $gallery['gallery_id'],
	'gathering_id'	=> $gathering['gathering_id'],
], true);


$af->ok();
