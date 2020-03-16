<?php


require_once('../profile.php.inc');



////////////////////////////////////////////////////////////////////////////////
//RENDER MUTUAL FRIENDS FOR PROFILE
////////////////////////////////////////////////////////////////////////////////
cpn_user::collect($db, [
	'table' => ['fw' => 'pudl_follow'],
	'clause' => [
		cpnFilterUserType(),
		'us.user_id'	=> pudl::neq($profile->user_id),

		'fw.user_id'	=> $profile->user_id,
		'us.user_id=fw.follow_id',
	],
	'order' => ['user_name' => pudl::asc()],
])->render($af);
