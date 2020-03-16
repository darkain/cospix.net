<?php
$user->requireLogin();

$hash	= $get->string('hash');
$id		= $get->id('gallery');


//PULL THE GALLERY DATA
$image = $db->row([
	'gi' => 'pudl_gallery_image',
	'ga' => 'pudl_gallery',
], [
	'file_hash'		=> pudl::unhex($hash),
	'ga.gallery_id'	=> $id,
	'ga.gallery_id=gi.gallery_id',
]);
\af\affirm(404, $image);


\af\affirm(401, $user->is($image));


$thumb = $db->row('pudl_file_thumb', [
	'file_hash'		=> pudl::unhex($hash),
	'thumb_type'	=> '200', //yes, keep this a string
]);
\af\affirm(422, $thumb);


$db->updateId('pudl_gallery', [
	'gallery_thumb' => pudl::unhex($hash),
], 'gallery_id', $id);
