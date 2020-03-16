<?php

require_once('get.php.inc');


$update = ['user_name' => $get->string('text')];

//TODO: VERIFY USER NAME AGAINST BANNED LIST

//TODO: TEST THIS AGAINST BANNED CHARACTERS FOR USER NAMES

if (empty($update['user_name'])) {
	echo $team['user_name'];
} else {
	$db->updateId('pudl_user', $update, 'user_id', $team['team_id']);
	echo $update['user_name'];
}
