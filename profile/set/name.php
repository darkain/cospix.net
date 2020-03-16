<?php
$user->requireLogin();

$update = [
	'user_name' => $get->string('text')
];

//TODO: LIMIT POSSIBLE CHARACTERS IN USER NAME

//TODO: VERIFY USER NAME AGAINST BANNED LIST

if (empty($update['user_name'])) {
	echo $user['user_name'];
} else {
	$user->update($update);
	echo $update['user_name'];
}
