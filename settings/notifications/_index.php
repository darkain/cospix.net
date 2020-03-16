<?php

//alpha tester?
$user->badge['alpha'] = $db->clauseExists('pudl_user_badge', [
	'badge_id=1',
	'user_id' => $user['user_id'],
]);

$user['adfree'] = (int)!!$user['user_adfree'];


$af->load('_index.tpl');
	$af->field('prefs', $user->getPreferences());
$af->render();
