<?php
$user->requireStaff();

require_once('../tag.php.inc');


$af->title = "Admin - $af->title";


$render = [];



/////////////////////////////////////////////
// RENDER ALL THE THINGS
/////////////////////////////////////////////
$afurl->jq = 'admin/_index.tpl';

if ($get->int('jq')) {
	$af	->load($afurl->jq)
		->field('profile', $profile)
		->field('tag', $group)
		->merge($render)
		->render();
} else {
	require('_index.php');
}
