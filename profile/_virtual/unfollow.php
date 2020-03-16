<?php

$user->requireLogin();

require_once('profile.php.inc');


$db->delete('pudl_follow',[
	'user_id'	=> $user['user_id'],
	'follow_id'	=> $profile['user_id'],
]);


echo '+ Follow';
