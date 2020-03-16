<?php

$badge = $db->clauseExists('pudl_user_badge', [
	'badge_id'	=> 1,
	'user_id'	=> $user['user_id'],
]);
\af\affirm(401, $badge);


$user->update([
	'user_adfree' => ($get->bool('value')) ? '253402300799' : 0,
]);
