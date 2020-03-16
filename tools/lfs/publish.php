<?php
$user->requireLogin();


$location = $db->rowId('pudl_location', 'location_name', $get('location'));


$db->insert('pudl_looking', [
	'user_id'			=> $user['user_id'],
	'event_id'			=> 1108,
	'location_id'		=> empty($location) ? NULL : $location['location_id'],
	'lfs_timestamp'		=> $db->time(),
	'lfs_iam'			=> strtolower($get->string('iam')),
	'lfs_lookingfor'	=> strtolower($get->string('looking')),
	'lfs_message'		=> $get->string('text'),
], true);

echo $db->time();
