<?php
$user->requireLogin();

$new = false;

$code = $db->row(
	'pudl_invite',
	['invite_sender' => $user['user_id']],
	['invite_created'=>pudl::dsc()]
);

if (empty($code)) {
	$new = true;
} else if (date('z',$db->time())  !==  date('z',$code['invite_created'])) {
	$new = true;
}

if ($new) {
	$md5 = strtoupper(substr(md5(microtime() . rand(). $user['user_id']), 16));

	$db->insert('pudl_invite', [
		'invite_code'		=> pudl::unhex($md5),
		'invite_sender'		=> $user['user_id'],
		'invite_created'	=> $db->time(),
		'invite_badge'		=> 9,
	]);
}


$codes = $db->rows(
	'pudl_invite',
	['invite_sender' => $user['user_id']],
	'invite_created'
);


foreach ($codes as &$code) {
	$code['code'] = bin2hex($code['invite_code']);
} unset($code);

$af->renderBlock('codes.tpl', 'code', $codes);
