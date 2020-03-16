<?php

if (empty($af->title)) $af->title = 'Blogs';

$articles = $db->selectRows(
	'*',
	['us'=>_pudl_user(50), 'ar'=>'pudl_article'],
	['ar.user_id=us.user_id', 'article_type'=>$article, cpnFilterBanned()],
	['article_timestamp'=>pudl::dsc()],
	10
);

$afurl->cdnAll($articles, 'img', 'thumb_hash');

$af->header();
	$af->load('article.tpl');
		$af->block('article', $articles);
	$af->render();
$af->footer();
