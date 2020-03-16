<?php
$user->requireLogin();


$team = $db->row(
	['tm' => 'pudl_team', 'us' => 'pudl_user'],
	[
		'us.user_id=tm.team_id',
		'us.user_permission'	=> 'team',
		'tm.team_id'			=> $get->id(),
		'tm.user_id'			=> $user['user_id'],
	]
);

\af\affirm(404, $team);
\af\affirm(401, $team['team_member_type'] === 'leader');
