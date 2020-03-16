<?php
$user->requireLogin();

$codes = $db->rows(
	'pudl_invite',
	['invite_sender' => $user['user_id']],
	'invite_created'
);


foreach ($codes as &$code) {
	$code['code'] = bin2hex($code['invite_code']);
} unset($code);


$af->header();
	$af->load('_index.tpl');
		$af->block('code', $codes);
	$af->render();
$af->footer();
