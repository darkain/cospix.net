<?php
$user->requireLogin();


$hash = $get->string('hash');


$file = $db->row('pudl_file_user', [
	'file_hash'	=> pudl::unhex($hash),
	'user_id'	=> $user['user_id'],
]);
\af\affirm(404, $file);


$db->update('pudl_file_user', [
	'file_text'	=> $get->string('text'),
], [
	'file_hash'	=> pudl::unhex($hash),
	'user_id'	=> $user['user_id'],
]);


//TODO: LINKIFY??
echo str_replace("\n", "<br />\n", $get->string('text'));
