<?php

require_once('../set/get.php.inc');

//TRANSACTIONS!!!
$db->begin();


$list = $get->intList('selected');
foreach ($list as $user_id) {
	$db->insert('pudl_team', [
		'team_id'			=> $team['user_id'],
		'user_id'			=> $user_id,
		'team_added_by'		=> $user['user_id'],
		'team_timestamp'	=> $db->time(),
	], 'user_id=user_id');
}


//TRANSACTIONS!!!
$db->commit();
