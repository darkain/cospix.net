<?php

if (!$user->loggedIn()) {
	return $af->renderPage('login.tpl');
}


$af->title = 'Submit A New Convention';

$af	->js('_index.js')
	->css('_index.css')
	->header()
		->render('_index.tpl')
	->footer();
