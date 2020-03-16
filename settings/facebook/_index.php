<?php

$facebook = $db->rowId('pudl_user_facebook', 'pudl_user_id', $user['user_id']);
if (empty($facebook)) {
	$facebook = $db->rowId('pudl_user_facebook', 'pudl_user_id', 0);
}


$af->load('_index.tpl');
	$af->field('prefs', $user->getPreferences());
	$af->field('facebook', $facebook);
$af->render();
