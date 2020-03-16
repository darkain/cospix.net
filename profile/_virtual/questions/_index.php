<?php


$af->title = 'Questions';


require_once('../profile.php.inc');




////////////////////////////////////////////////////////////
//LOAD ALL THE CONTENTS!!
////////////////////////////////////////////////////////////
$render['questions'] = $db->rows(
	['ak'=>'pudl_ask', 'us'=>_pudl_user(100)],
	[
		'ak.sender_id=us.user_id',
		'answer_time>0',
		'receiver_id' => $profile['user_id'],
		cpnFilterBanned(),
	],
	['answer_time'=>pudl::dsc()]
);

$afurl->cdnAll($render['questions'], 'url', 'thumb_hash');




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////
$afurl->jq = 'questions/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq);
		$af->field('user', $profile);
		$af->merge($render);
	$af->render();
} else {
	require('_index.php');
}
