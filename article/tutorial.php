<?php
$af->title = 'Tutorials';
$article = 'tutorial';

$articles = $db->selectRows(
	'*',
	[
		'us'=>_pudl_user(50),
		'ar'=>['pudl_article', ['left'=>'pudl_youtube', 'using'=>'youtube_id']],
	],
	['article_type'=>$article, 'ar.user_id=us.user_id', cpnFilterBanned()],
	['article_timestamp'=>pudl::dsc()],
	10
);

$afurl->cdnAll($articles, 'img', 'thumb_hash');

$af->header();
	$af->load('tutorial.tpl');
		$af->block('article', $articles);
	$af->render();
$af->footer();
