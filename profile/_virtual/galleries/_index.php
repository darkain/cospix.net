<?php


require_once('../profile.php.inc');




////////////////////////////////////////////////////////////////////////////////
//IF WE HAVE A SEARCH QUERY, PROCESS IT INSTEAD!
////////////////////////////////////////////////////////////////////////////////
$afurl->search	= $afurl([$profile, 'galleries', 'search'], true);
$af->title		= 'Galleries';
$afurl->jq		= 'galleries/_index.tpl';
$block			= 'item';




////////////////////////////////////////////////////////////////////////////////
//HIDE EMPTY GALLERIES IF PROFILE IS NOT CURRENT USER
////////////////////////////////////////////////////////////////////////////////
$clause		= [];
if (!$profile->is($user)) {
	$clause[] = ['thumb_hash' => pudl::neq(NULL)];
}




////////////////////////////////////////////////////////////////////////////////
//LOAD ALL THE CONTENTS!!
////////////////////////////////////////////////////////////////////////////////
require('search.php');
$render[$block] = $galleries;





////////////////////////////////////////////////////////////////////////////////
//HEADER
////////////////////////////////////////////////////////////////////////////////
$render[$block]->header = [
	'template'	=> [
		'galleries/header.tpl',
		'_cospix/search.tpl',
	],
	'profile'	=> $profile,
	'search'	=> $get->search,
];




////////////////////////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////////////////////////
if ($get->int('jq')) {
	$af->load($afurl->jq)->merge($render)->render();

} else {
	require('_index.php');
}
