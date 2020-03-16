<?php

if ($af->device() === 'desktop')	\af\device::redetect();
if ($af->device() === 'mobile')		\af\device::set('tablet');


$articles = [$db->row([
	'us' => _pudl_user(50),
	'ar' => 'pudl_article'
], [
	'ar.user_id=us.user_id',
	'article_id' => $router->id,
	cpnFilterBanned(),
])];

if (empty($articles[0])) \af\error(404);

$af->title = $articles[0]['article_title'];

$og['description'] = afString::striphtml($articles[0]['article_text'], 1000);



$afurl->cdnAll($articles, 'img', 'thumb_hash');


$af->header();
	$af->renderBlock('article.tpl', 'article', $articles);
$af->footer();
