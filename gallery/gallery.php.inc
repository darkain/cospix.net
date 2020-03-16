<?php

$gallery['upload'] = $get->int('upload');


/////////////////////////////////////////////
// OPEN GRAPH DATA - FACEBOOK
/////////////////////////////////////////////
$id = $get->string('id');
$item = false;
if (!empty($id)) {
	//NOTE: KEEP THESE NUMBERS INSIDE OF STRINGS!
	$item	= $db->row('pudl_file_thumb', ['file_hash'=>pudl::unhex($id), 'thumb_type'=>'200']);
	$large 	= $db->row('pudl_file_thumb', ['file_hash'=>pudl::unhex($id), 'thumb_type'=>'800']);
}

if (!empty($item)) {
	$og['image'] = $afurl->cdn($item['thumb_hash']);

	if (!empty($large)) {
		$af->metas([
			['name'=>'twitter:card',	'content'=>'photo'],
			['name'=>'twitter:site',	'content'=>'@cospixnet'],
			['name'=>'twitter:domain',	'content'=>'Cospix.net'],
			['name'=>'twitter:title',	'content'=>"$af->title - $og[title]"],
			['name'=>'twitter:image',	'content'=>$afurl->cdn($large['thumb_hash'])],
		]);
	}

} else {
	if (!empty($gallery['img'])) $og['image'] = $gallery['img'];
}




/////////////////////////////////////////////
// GET IMAGES
/////////////////////////////////////////////
$thumbs = $db->rows(
	array_merge($gallery_table, [
		'fl' => _pudl_file(100),
		'fu' => 'pudl_file_user',
	]),
	array_merge($gallery_clause, [
		'fl.file_hash=fu.file_hash',
	]),
	['image_time'=>pudl::dsc()]
);



/////////////////////////////////////////////
// PROCESS IMAGES
/////////////////////////////////////////////
foreach ($thumbs as $key => &$val) {
	$val['url'] = $afurl->cdn($val['thumb_hash']);
	$val['img'] = $afurl->cdn($val);
} unset($val);



/////////////////////////////////////////////
// RENDER
/////////////////////////////////////////////
if (!$get->int('jq')) $af->header();

$af->load('_virtual.tpl');
	$af->field('gallery', $gallery);
	$af->block('thumbs', $thumbs);
$af->render();

$af->footers('footer', 0);
if (!$get->int('jq')) $af->footer();
