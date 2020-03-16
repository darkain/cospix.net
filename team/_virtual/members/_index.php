<?php

require_once('../team.php.inc');


$af->title = "Members - $af->title";


$render['user'] = $db->rows(
	[
		'tm'=>'pudl_team',
		'us'=>_pudl_user(200),
		'up'=>'pudl_user_profile',
	],
	[
		'tm.user_id=us.user_id',
		'up.user_id=us.user_id',
		'tm.team_id' => $team['user_id'],
	],
	[
		'team_member_type'	=> pudl::neq('leader'),
		'team_timestamp'	=> pudl::dsc(),
		'user_name',
	]
);

$afurl->cdnAll($render['user'], 'img', 'thumb_hash');




/////////////////////////////////////////////
// RENDER ALL THE THINGS
/////////////////////////////////////////////
$afurl->jq = 'members/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq);
		$af->field('team',		$team);
		$af->field('profile',	$profile);
		$af->merge($render);
	$af->render();
} else {
	require('_index.php');
}
