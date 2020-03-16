<?php
$user->requireLogin();

//TODO: REPLACE THESE WITH THE NEW PROFILE VERSIONS

$id = $get->id();
$follow = $db->rowId('pudl_user', 'user_id', $id);
\af\affirm(404, $follow);

//TODO: cpnFilterBanned(),

$db->delete('pudl_follow', [
	'user_id'	=> $user['user_id'],
	'follow_id'	=> $follow['user_id'],
]);
