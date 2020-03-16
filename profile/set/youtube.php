<?php
$user->requireLogin();



$youtube = $get->string('youtube');
if (empty($youtube)) {
	$db->updateId('pudl_user_profile', [
		'youtube_id' => NULL,
	], 'user_id', $user);

	echo '<script>refresh()</script>';
	return;
}



$ytid = (new \af\youtube($af, $db))->importPath($youtube);

$db->updateId('pudl_user_profile', [
	'youtube_id' => empty($ytid) ? NULL : $ytid,
], 'user_id', $user);

echo '<script>refresh()</script>';
