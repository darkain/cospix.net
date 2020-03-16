<?php


////////////////////////////////////////////////////////////
//PULL TEAM DATA
////////////////////////////////////////////////////////////
$team = $db->selectRow(
	['us.*', 'up.*', 'th.thumb_hash', 'tm.team_member_type'],
	['us'=>_pudl_user(150)+[
		['natural'=>['up'=>'pudl_user_profile']],
		['left'=>['tm'=>'pudl_team'], 'on'=>[
			'tm.team_id=us.user_id', 'tm.user_id'=>$user['user_id']
		]],
	]],
	['us.user_id'=>$router->id]
);

\af\affirm(404, $team);
\af\affirm(404, $team['user_permission'] === 'team');

$af->title = $team['user_name'];




////////////////////////////////////////////////////////////
//FIX TEXT
////////////////////////////////////////////////////////////
$team['bio'] = afString::linkify($team['user_bio']);




////////////////////////////////////////////////////////////
//REBASE CURRENT WORKING DIRECTORY
////////////////////////////////////////////////////////////
if (count($router->virtual) > 1) {
	array_pop($router->virtual);
	chdir('../');
	$team['subpage'] = 1;
}




////////////////////////////////////////////////////////////
//BUILD PROFILE DATA
////////////////////////////////////////////////////////////
$profile = [
	'type'	=> 'team',
	'id'	=> $team['user_id'],
	'url'	=> 'team/' . $team['user_id'],
	'name'	=> $team['user_name'],
	'img'	=> $afurl->cdn($team['thumb_hash']),
	'sub'	=> $team['user_tagline'],
	'edit'	=> $team['team_member_type'] === 'leader',
	'imgdefault' => 'profile.svg',
];
