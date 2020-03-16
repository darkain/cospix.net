<?php
////////////////////////////////////////////////////////////
//DELETE AN IMAGE OUT OF A GALLERY / COSTUME
//SEE /GALLERY/REMOVE/ TO DELETE THE GALLERY ITSELF
////////////////////////////////////////////////////////////

$user->requireLogin();

if (count($router->virtual) < 2) \af\error(404);

$id		= (int) $router->virtual[0];
$hash	= $router->virtual[1];




////////////////////////////////////////////////////////////
//PULL IMAGE DATA
////////////////////////////////////////////////////////////
$image = $db->row([
	'ci' => 'pudl_gallery_image',
	'co' => 'pudl_gallery'
], [
	'ci.file_hash'	=> pudl::unhex($hash),
	'ci.gallery_id'	=> $id,
	'ci.gallery_id=co.gallery_id'
]);
\af\affirm(404, $image);




////////////////////////////////////////////////////////////
//VERIFY OWNERSHIP
////////////////////////////////////////////////////////////
\af\affirm(401, $user->is($image));




////////////////////////////////////////////////////////////
//DELETE THE IMAGE
////////////////////////////////////////////////////////////
$db->delete('pudl_gallery_image', [
	'file_hash'		=> pudl::unhex($hash),
	'gallery_id'	=> $id,
]);




////////////////////////////////////////////////////////////
//DELETE FROM PEOPLE'S FAVORITES
////////////////////////////////////////////////////////////
$db->delete('pudl_favorite', [
	'file_hash'		=> pudl::unhex($hash),
	'gallery_id'	=> $id,
]);




////////////////////////////////////////////////////////////
//UPDATE CREDIT QUANTITY
////////////////////////////////////////////////////////////
$db->updateCount('pudl_file', 'file_credits', [
	'file_hash' => pudl::unhex($hash),
], 'pudl_gallery_image');




////////////////////////////////////////////////////////////
//UPDATE FAVORITE QUANTITY
////////////////////////////////////////////////////////////
$db->updateCount(
	'pudl_file',
	'file_favorites',
	['file_hash' => pudl::unhex($hash)],
	'pudl_favorite'
);




//DELETE COMMENTS, NOTIFICATIONS, AND FEED ACTIVITY
//TODO: we cannot delete these, other instances of image may exist!
$clause = [
	'file_hash'			=> pudl::unhex($hash),
	'object_type_id'	=> $af->type('image'),
];
//$db->delete('pudl_comment',		$clause);
//$db->delete('pudl_notification',	$clause);
//$db->delete('pudl_activity',		$clause);
