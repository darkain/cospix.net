<?php

$google = $db->rowId('pudl_user_google', 'pudl_user_id', $user['user_id']);
if (empty($google)) {
	$google = $db->rowId('pudl_user_google', 'pudl_user_id', 0);
}


$af->load('_index.tpl');
	$af->field('prefs', $user->getPreferences());
	$af->field('google', $google);
$af->render();
