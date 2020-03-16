<?php

$min_pass_length = 8;


if ($user->loggedIn()) {
	$afurl->redirect($user, 302);
}

$error = '';

if (!empty($get('auth_account'))) {
	$error = require('create.php.inc');
}

$af->renderPage('_index.tpl', [
	'regerror'		=> $error,
	'minpass'		=> $min_pass_length,
	'auth_account'	=> $get('auth_account'),
]);
