<?php
$user->requireLogin();

$gallery = $db->rowId('pudl_gallery', 'gallery_id', $get->id());
\af\affirm(404, $gallery, 'Invalid Gallery');
\af\affirm(401, $user->is($gallery));


//UPCOMING GATHERINGSS
$result = $db->group(
	['ug.*', 'gt.*', 'th.*'],
	['ug'=>'pudl_user_gathering', 'gt'=>_pudl_gathering(200)],
	['gt.gathering_id=ug.gathering_id', 'ug.user_id'=>$user['user_id']],
	'gt.gathering_id',
	['gt.gathering_start'=>pudl::dsc()]
);
$render = ['g'=>$result->rows()];
$result->free();

$afurl->cdnAll($render['g'], 'img', 'thumb_hash');



$af->load('add.tpl');
$af->field('gallery', $gallery);
$af->block('gathering', $render['g']);
$af->render();
