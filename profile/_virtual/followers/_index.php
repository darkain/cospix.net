<?php


$af->title = 'Followers';


require_once('../profile.php.inc');



if ($af->prometheus()) {
	$block	= 'item';
} else {
	$block	= 'follow';
}




//TODO: SHOWING MUTUALS, BUT MAKE TABS FOR ALL FOLLOWING AND ALL FOLLOWERS
////////////////////////////////////////////////////////////////////////////////
//PULL USER DATA
////////////////////////////////////////////////////////////////////////////////
if ($block === 'item') {
	$render[$block] = cpn_user::collect($db, [
		'table' => [
			'fw' => 'pudl_follow',
			'fx' => 'pudl_follow',
		],
		'clause' => [
			cpnFilterUserType(),
			'us.user_id'	=> pudl::neq($profile->user_id),

			'fw.follow_id'	=> $profile->user_id,
			'us.user_id=fw.user_id',

			'fx.user_id'	=> $profile->user_id,
			'us.user_id=fx.follow_id',
		],
		'order' => ['user_name' => pudl::asc()],
	]);
} else {
	$render[$block] = cpn_user::collect($db, [
		'table' => ['fw' => 'pudl_follow'],
		'clause' => [
			cpnFilterUserType(),
			'us.user_id'	=> pudl::neq($profile->user_id),

			'fw.follow_id'	=> $profile->user_id,
			'us.user_id=fw.user_id',
		],
		'order' => ['user_name' => pudl::asc()],
	]);
}

foreach ($render[$block] as $item) {
	$item->following = false;
}




////////////////////////////////////////////////////////////////////////////////
//HEADER
////////////////////////////////////////////////////////////////////////////////
if ($af->prometheus()) {
	$render[$block]->header = [
		'template'	=> 'followers/header.tpl',
		'profile'	=> $profile,
	];
}




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////
$afurl->jq = 'followers/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq);
		$af->field('user', $profile);
		$af->merge($render);
	$af->render();
} else {
	require('_index.php');
}
