<?php

$twitter = $db->rowId('pudl_user_twitter', 'pudl_user_id', $user['user_id']);
if (empty($twitter)) {
	$twitter = $db->rowId('pudl_user_twitter', 'pudl_user_id', 0);
}


$af->load('_index.tpl');
	$af->field('prefs', $user->getPreferences());
	$af->field('twitter', $twitter);
$af->render();
