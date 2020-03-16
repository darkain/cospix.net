<?php

$id = $get->id();



/////////////////////////////////////////////
// GALLERY
/////////////////////////////////////////////
$gallery = $db->rowId('pudl_gallery', 'gallery_id', $id);




/////////////////////////////////////////////
// IMAGES
/////////////////////////////////////////////
$images = $db->selectRows(
	['th.*', 'gi.*'],
	['gi' => _pudl_gallery_image(200)],
	['gallery_id' => $id],
	['image_sort', 'image_time'=>pudl::dsc()]
);

foreach ($images as &$item) {
	$item['hash'] = bin2hex($item['file_hash']);
} unset($item);
$afurl->cdnAll($images, 'img', 'thumb_hash');




/////////////////////////////////////////////
// RENDER
/////////////////////////////////////////////
$af->load('thumbs.tpl');
	$af->field('profile', $gallery);
	$af->field('gallery', $gallery);
	$af->block('g', $images);
$af->render();
echo '<div class="clear">&nbsp;</div>';
