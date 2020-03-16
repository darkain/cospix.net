<?php

//Display Login Popup
if ($get->int('jq')) {
	return $af->render('_index.tpl');
}


//If we're logged in, redirect!
if ($user->loggedIn()) {
	return require_once('redirect.php.inc');
}


//Display Login Page
$af->renderPage('login.tpl');
