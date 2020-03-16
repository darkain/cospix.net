<?php
$user->requireLogin();

$gathering = $db->rowId('pudl_gathering', 'gathering_id', $get->id());
\af\affirm(404, $gathering);

$db->delete('pudl_user_gathering', [
	'user_id'		=> $user['user_id'],
	'gathering_id'	=> $get->id(),
]);
