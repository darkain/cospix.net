<?php

$af->title = 'Teams';


//PULL LISTING OF ALL TEAMS
$teams = $db->selectRows(
	['us.*', 'up.*', 'th.thumb_hash', 'tm.team_member_type'],
	['us'=>_pudl_user(150)+[
		['natural'=>['up'=>'pudl_user_profile']],
		['join'=>['tm'=>'pudl_team'], 'on'=>[
			'tm.team_id=us.user_id', 'tm.user_id'=>$user['user_id']
		]],
	]]
);


$afurl->cdnAll($teams, 'img', 'thumb_hash');


$af->header();
	$af->load('_index.tpl');
		$af->block('team', $teams);
	$af->render();
$af->footer();
