<?php

\af\affirm(404,
	$gallery = $db->rowId(['ga'=>_pudl_gallery(200)], 'gallery_id', $router->id)
);


$af->title = $gallery['gallery_name'];

$gallery['img'] =  $afurl->cdn($gallery, 'thumb_hash');

// OPEN GRAPH, TWITTER CARD, MICRO DATA
$og['description'] = substr($gallery['gallery_name'], 0, 300);


///////////////////
$gallery_table	= ['gi' => 'pudl_gallery_image'];

$gallery_clause	= [
	'fl.file_hash=gi.file_hash',
	'gi.gallery_id'	=> $gallery['gallery_id'],
	'fu.user_id'	=> $gallery['user_id'],
];

$gallery['id'] = $gallery['gallery_id'];
$gallery['type'] = 'gallery';


$afurl->redirect( '/image/' . $get->hash('id') . '?gallery=' . $router->id );

//require('gallery.php.inc');
