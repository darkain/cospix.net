<?php

$user->requireLogin();

$hash = $get->hash();




////////////////////////////////////////////////////////////
//LOAD THE IMAGE
////////////////////////////////////////////////////////////
\af\affirm(404,
	$image = $db->row([
		'fu' => 'pudl_file_user',
		'fl' => _pudl_file(100)
	], [
		'fu.file_hash=fl.file_hash',
		'fu.file_hash'	=> pudl::unhex($hash),
		'fu.user_id'	=> $user['user_id'],
	])
);




////////////////////////////////////////////////////////////
//NOTIFY CREDITED USERS
////////////////////////////////////////////////////////////
$ok = false;
$users = explode(',', $get->string('selected'));
foreach ($users as $id) {
	if (empty($id)) continue;

	if ($db->clauseExists('pudl_file_user', [
		'file_hash'	=> pudl::unhex($hash),
		'user_id'	=> $id,
	])) continue;

	$ok = true;

	$db->insert('pudl_file_user', [
		'file_hash'			=> pudl::unhex($hash),
		'user_id'			=> $id,
		'user_time'			=> $db->time(),
		'file_credit_by'	=> $user['user_id']
	], [
		'user_id'			=> $id
	]);

	$db->insert('pudl_notification', [
		'object_type_id'			=> $af->type('tag'),
		'file_hash'					=> pudl::unhex($hash),
		'notification_user_from'	=> $user['user_id'],
		'notification_user_to'		=> $id,
		'notification_timestamp'	=> $db->time(),
		'notification_read'			=> 0,
	]);
}




////////////////////////////////////////////////////////////
//OUTPUT RESPONSE
////////////////////////////////////////////////////////////
if ($ok) {
	echo '<script>refresh();</script>';
} else {
	echo '<script>popdown();</script>';
}
