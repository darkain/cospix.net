<?php


$af->title = 'Articles';


require_once('../profile.php.inc');



////////////////////////////////////////////////////////////
//Get and validate the article type!
////////////////////////////////////////////////////////////
$profile['article_type'] = $get->string('type');
$clause = [
	'ar.user_id=us.user_id',
	'us.user_id' => $profile['user_id']
];

switch ($profile['article_type']) {
	case 'article':
	case 'tutorial':
	case 'conreport':
	case 'productreview':
		$clause['ar.article_type'] = $profile['article_type'];
}




////////////////////////////////////////////////////////////
//LOAD ALL THE CONTENTS!!
////////////////////////////////////////////////////////////
$render['article'] = $db->rows([
	'us' => _pudl_user(50),
	'ar' => ['pudl_article', ['left'=>'pudl_youtube', 'using'=>'youtube_id']]
], $clause, ['article_timestamp'=>pudl::desc()]);

$afurl->cdnAll($render['article'], 'img', 'thumb_hash');




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////
$afurl->jq = 'articles/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq);
		$af->field('user', $profile);
		$af->merge($render);
	$af->render();
} else {
	require('_index.php');
}
