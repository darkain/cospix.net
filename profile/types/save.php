<?php

$user->requireLogin();




////////////////////////////////////////////////////////////////////////////////
//GET THE COMPLETE LIST OF TYPES
////////////////////////////////////////////////////////////////////////////////
require_once('types.php.inc');




////////////////////////////////////////////////////////////////////////////////
//GET AND PROCESS TYPES
////////////////////////////////////////////////////////////////////////////////
$safe	= [];
$types	= explode(',', $get->string('types'));

foreach ($types as $type) {
	$key = array_search($type, $afusertypes);
	if (!empty($key)) $safe[] = $key;
}




////////////////////////////////////////////////////////////////////////////////
//UPDATE USER IN DATABASE
////////////////////////////////////////////////////////////////////////////////
$user->update(['user_type' => implode(',', $safe)]);




////////////////////////////////////////////////////////////////////////////////
//OKAY!!
////////////////////////////////////////////////////////////////////////////////
$af->ok();