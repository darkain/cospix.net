<?php
//Authentication
require_once('get.php.inc');


//Update
$db->updateId('pudl_user_profile', [
	'user_tagline' => $get->string('text')
], 'user_id', $team['team_id']);


//Display update
echo $get->string('text', _GETVAR_HTMLSAFE);
