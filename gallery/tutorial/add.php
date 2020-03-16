<?php
$user->requireLogin();

$gallery = $db->rowId('pudl_gallery', 'gallery_id', $get->id());
\af\affirm(404, $gallery, 'Invalid Gallery');
\af\affirm(401, $user->is($gallery));


$render['tutorial'] = $db->rows(
	'pudl_article',
	['article_type'=>'tutorial'],
	'article_title'
);



$af->load('add.tpl');
$af->field('gallery', $gallery);
$af->block('tutorial', $render['tutorial']);
$af->render();
