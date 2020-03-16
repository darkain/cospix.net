<?php

if (count($router->virtual) > 1) \af\error(404);

require_once('tutorial.php.inc');
require_once('_cospix/products.php.inc');




////////////////////////////////////////////////////////////
//PRODUCTS
////////////////////////////////////////////////////////////
$products = (new cpnProduct($af, $db))->suggest();
array_splice($products, 4);




////////////////////////////////////////////////////////////
//BUILD PROFILE DATA
////////////////////////////////////////////////////////////
$profile = [
	'type'	=> 'tutorial',
	'id'	=> $tutorial['article_id'],
	'url'	=> 'tutorial/' . $tutorial['article_id'],
	'name'	=> $tutorial['article_title'],
	'img'	=> $afurl->cdn($tutorial['thumb_hash']),
	'sub'	=> '',
	'edit'	=> $user->is($tutorial),
	'imgdefault' => 'tutorial.png',
];




////////////////////////////////////////////////////////////
//BUILD MENU DATA
////////////////////////////////////////////////////////////
$menu = [
/*	'Products'		=> $db->clauseExists(
		'pudl_product',
		['vendor_id'=>$vendor['vendor_id'], 'product_type'=>'retail']
	),
	'Services'		=> $db->clauseExists(
		'pudl_product',
		['vendor_id'=$vendor['vendor_id'], 'product_type'='streaming']
	),
	'Cosplayers'	=> 1,
	'Costumes'		=> 1,
	'Photos'		=> 1,
	'Fans'			=> 0,*/
	'Staff'			=> 0,//$user->isAdmin())  ||  ($user->is($tutorial),
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
	'object_id'			=> $vendor['vendor_id'],
	'object_type_id'	=> $af->type('vendor'),
]);
*/




////////////////////////////////////////////////////////////
//BODY CONTENT
////////////////////////////////////////////////////////////
if (empty($tutorial['subpage'])) {
	require_once('tutorial/index.php.inc');
}




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS
////////////////////////////////////////////////////////////
if (empty($afurl->jq)) {
	$afurl->jq = 'tutorial/_index.tpl';
}

if ($get->int('jq')) {
	$af->load('tutorial/_index.tpl');
} else {
	$af->header();
	$af->load('_cospix/profile.tpl');
}

$af->field('article',	$tutorial);
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
