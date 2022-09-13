<?php
//Authentication
require_once('get.php.inc');


//Update
$db->updateId('pudl_user_profile', [
	'user_tagline' => $get('text')
], 'user_id', $team['team_id']);


//Display update
echo htmlspecialchars($get('text'));
