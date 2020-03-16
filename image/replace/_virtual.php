<?php

$user->requireAdmin();

$hash = $router->virtual[0];

$image = $db->row([
	'fl' => _pudl_file(800),
	'mt' => 'pudl_mimetype',
], [
	'fl.mime_id=mt.mime_id',
	'fl.file_hash' => pudl::unhex($hash),
]);

if (empty($image)) \af\error(404);


$image['img'] = $afurl->cdn($image, 'thumb_hash');
$image['hash'] = $hash;


$af->header();
	$af->load('_virtual.tpl');
		$af->field('image', $image);
	$af->render();
$af->footer();
