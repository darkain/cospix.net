<?php
$user->requireStaff();
$id = $get->id();

$update = array(
	'user_permission' => $get->string('user_permission'),
	'user_badge' => implode(',', $get->stringArray('user_badge')),
);

$db->updateId('pudl_user', $update, 'user_id', $id);

$af->purgeSession();
