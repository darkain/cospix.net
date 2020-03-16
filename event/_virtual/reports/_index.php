<?php

$af->title = 'Reports';
$og['description'] = 'Reports from ';

require_once('../event.php.inc');




/////////////////////////////////////////////
// PULL ARTICLES
/////////////////////////////////////////////
$render['article'] = $db->rows([
	'us' => _pudl_user(50),
	'ar' => 'pudl_article',
], [
	'ar.user_id=us.user_id',
	'event_id' => $event['event_id'],
	cpnFilterBanned(),
], [
	'article_timestamp'=>pudl::dsc()
]);

$afurl->cdnAll($render['article'], 'img', 'thumb_hash');




/////////////////////////////////////////////
// RENDER ALL THE THINGS
/////////////////////////////////////////////
$afurl->jq = 'reports/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq);
		$af->field('event', $event);
		$af->block('article', $render['article']);
	$af->render();
} else {
	require('_index.php');
}
