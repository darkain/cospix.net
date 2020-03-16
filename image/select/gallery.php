<?php

$user->requireLogin();

$gallery = $db->rowId('pudl_gallery', 'gallery_id', $get->id());
\af\affirm(404, $gallery);
\af\affirm(401, $user->is($gallery));


$images = $db->rows([
	'gi' => _pudl_gallery_image(200),
], [
	'gi.gallery_id' => $gallery['gallery_id'],
], [
	'image_sort'=>pudl::dsc(),
]);

$afurl->cdnAll($images, 'img', 'thumb_hash', 'mime_id');


$af->load('gallery.tpl');
	$af->block('g', $images);
$af->render();
