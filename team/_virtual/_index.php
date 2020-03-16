<?php

require_once('team.php.inc');
require_once('_cospix/products.php.inc');




////////////////////////////////////////////////////////////
//PRODUCTS
////////////////////////////////////////////////////////////
$products = (new cpnProduct($af, $db))->suggest();
array_splice($products, 4);




////////////////////////////////////////////////////////////
//BUILD MENU DATA
////////////////////////////////////////////////////////////
$menu = [
	'Members'		=> true,
/*	'Fans'			=> 0,*/
	'Staff'			=> 0,//$user->isAdmin()  ||  ($user->is($team),
];




////////////////////////////////////////////////////////////
//BUILD ADMIN MENU DATA
////////////////////////////////////////////////////////////
$admin = [];
if ($profile['edit']) {
	$admin = [
//		['text'=>'Edit Social Links', 'click'=>"$afurl->base/$profile[type]/links?id=$profile[id]"],
	];
}



////////////////////////////////////////////////////////////
//GET SOCIAL MEDIA LINKS
////////////////////////////////////////////////////////////
/*
$social = $db->rows('pudl_social', [
	'object_id'=>$vendor['vendor_id'],
	'object_type_id' => $af->type('vendor'),
]);
*/




////////////////////////////////////////////////////////////
//BODY CONTENT
////////////////////////////////////////////////////////////
if (empty($team['subpage'])) {
	require_once('team/index.php.inc');
}




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS
////////////////////////////////////////////////////////////
if (empty($afurl->jq)) {
	$afurl->jq = 'team/_index.tpl';
}

if ($get->int('jq')) {
	$af->load('team/_index.tpl');
} else {
	$af->header();
	$af->load('_cospix/profile.tpl');
}

$af->field('team',		$team);
$af->field('profile',	$profile);
$af->block('menu',		$menu);
$af->block('admin',		$admin);
$af->block('social',	[]);
$af->block('afproduct',	$products);

if (!empty($render)) $af->merge($render);

$af->render();

if (!$get->int('jq')) {
	$af->footer();
}
