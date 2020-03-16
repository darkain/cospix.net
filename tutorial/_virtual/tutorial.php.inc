<?php


////////////////////////////////////////////////////////////
//PULL VENDOR DATA
////////////////////////////////////////////////////////////
$tutorial = $db->rowId(
	['ar'=>array_merge(_pudl_article(150),[
		['natural'=>['us'=>'pudl_user']],
		['left'=>'pudl_youtube', 'using'=>'youtube_id'],
	])],
	'article_id', $router->id
);

\af\affirm(404, $tutorial);
if ($tutorial['article_type'] !== 'tutorial') \af\error(404);

if (empty($tutorial['article_title'])) $tutorial['article_title'] = $tutorial['youtube_title'];
$af->title = $tutorial['article_title'];




////////////////////////////////////////////////////////////
//FIX TEXT
////////////////////////////////////////////////////////////
//$tutorial['article_text'] = afString::linkify($tutorial['article_text']);
$tutorial['youtube_description'] = afString::linkify($tutorial['youtube_description']);




////////////////////////////////////////////////////////////
//REBASE CURRENT WORKING DIRECTORY
////////////////////////////////////////////////////////////
if (count($router->virtual) > 1) {
	array_pop($router->virtual);
	chdir('../');
	$tutorial['subpage'] = 1;
}
