<?php

if ($user->loggedIn()) {
	$afurl->redirect($user, 302);
}

$error = '';

if (!empty($get('auth_account'))) {
	$error = require('reset.php.inc');
	if ($error === true) return;
}

$af->renderPage('_index.tpl', [
	'regerror'		=> $error,
	'auth_account'	=> $get('auth_account'),
]);
