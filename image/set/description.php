<?php
$user->requireLogin();

$hash = $get->hash();
$update = ['file_text' => $get->string('value')];

$db->update('pudl_file_user', $update, [
	'user_id'	=> $user['user_id'],
	'file_hash'	=> pudl::unhex($hash),
]);

echo afString::linkify( $update['file_text'] );
