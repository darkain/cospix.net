<?php
$af->load('_index.tpl');
	$af->field('profile', $db->rowId('pudl_user_profile', 'user_id', $user['user_id']));
	$af->field('prefs', $user->getPreferences());
$af->render();
