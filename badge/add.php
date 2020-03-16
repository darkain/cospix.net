<?php
$user->requireLogin();

if ($user->isStaff()) {
	if ($get->id()) {
		$profile = $db->rowId('pudl_user', 'user_id', $get->id());
		if (empty($profile)) \af\error(404);
	} else {
		$profile = &$user;
	}
	$badge = $db->rows('pudl_badge', 'badge_id IN (13,15,24)');

} else {
	$profile	= &$user;
	$badge		= [];
}


$af->load('add.tpl');
	$af->field('profile',	$profile);
	$af->block('badge',		$badge);
$af->render();
