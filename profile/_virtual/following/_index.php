<?php


$af->title = 'Following';


require_once('../profile.php.inc');




////////////////////////////////////////////////////////////
//LOAD ALL THE CONTENTS!!
////////////////////////////////////////////////////////////
$render['follow'] = $db->selectRows(
	array(
		'fw.*',
		'uo.*',
		'us.*',
		'th.*',
		'following' => 'fx.follow_id',
	),
	array(
		'fw' => 'pudl_follow',
		'uo' => 'pudl_user_profile',
		'us' => array_merge(_pudl_user(100), array(array(
			'left' => array('fx' => 'pudl_follow'),
			'clause' => array(
				'fx.follow_id=us.user_id',
				'fx.user_id' => $user['user_id'],
			)
		)))
	),
	array(
		cpnFilterBanned(),
		'us.user_id=uo.user_id',
		'us.user_id=fw.follow_id',
		'fw.user_id'	=> $profile['user_id'],
		'us.user_id'	=> pudl::neq($profile['user_id']),
	),
	'user_name'
);

$afurl->cdnAll($render['follow'], 'img', 'thumb_hash');

$profile['following'] = count($render['follow']);




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////
$afurl->jq = 'following/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq);
		$af->field('user', $profile);
		$af->merge($render);
	$af->render();
} else {
	require('_index.php');
}
