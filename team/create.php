<?php
$user->requireLogin();


//TRANSACTIONS!!
$db->begin();


$name = $get->string('name');
\af\affirm(422, $name, 'Name can not be empty!');


$teamid = $db->insert('pudl_user', [
	'user_permission'	=> 'team',
	'user_type'			=> 'team',
	'user_name'			=> $name,
]);


$db->insert('pudl_user_profile', [
	'user_id'			=> $teamid,
]);


$db->insert('pudl_team', [
	'team_id'			=> $teamid,
	'user_id'			=> $user['user_id'],
	'team_added_by'		=> $user['user_id'],
	'team_timestamp'	=> $db->time(),
	'team_member_type'	=> 'leader',
]);


//TRANSACTIONS!!
$db->commit();
