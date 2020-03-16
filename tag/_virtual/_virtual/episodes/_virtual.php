<?php

require_once('../tag.php.inc');


$render = ['episode' => $db->rowId('pudl_youtube', 'youtube_id', $group['page_id'])];
\af\affirm(404, $render['episode']);

$af->title = $render['episode']['youtube_title'];

$render['episode']['text'] = afString::linkify($render['episode']['youtube_description']);




/////////////////////////////////////////////
// OPEN GRAPH
/////////////////////////////////////////////
$og['image']		= 'http://img.youtube.com/vi/' . $group['page_id'] . '/maxresdefault.jpg';
$og['keywords']		= implode(',', [$group['group_label']]);
$og['description']	= afString::truncateword($render['episode']['youtube_description'], 1000);

$af->metas([
	['name'=>'twitter:card',		'content'=>'photo'],
	['name'=>'twitter:site',		'content'=>'@cospixnet'],
	['name'=>'twitter:domain',		'content'=>'Cospix.net'],
	['name'=>'twitter:title',		'content'=>"$af->title - $og[title]"],
	['name'=>'twitter:image',		'content'=>&$og['image']],
	['name'=>'twitter:description',	'content'=>&$og['description']],
]);




/////////////////////////////////////////////
// RENDER ALL THE THINGS
/////////////////////////////////////////////
$afurl->jq = 'episodes/_virtual.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq)->merge($render)->render();
} else {
	require('_index.php');
}
