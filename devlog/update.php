<?php
$user->requireAdmin();

$db->updateId('pudl_devlog', [
	'log_text' => $get->string('text'),
], 'log_id', $get->id());

echo $get->string('text');
