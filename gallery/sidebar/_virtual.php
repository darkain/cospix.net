<?php


$hash	= $router->virtual[0];
$id		= $get->int('gallery');
$type	= $get->string('type');


//GET IMAGE DETAILS
$image = $db->row([
	'gi' => 'pudl_gallery_image',
	'ga' => 'pudl_gallery',
	'us' => 'pudl_user',
	'fu' => 'pudl_file_user',
], [
	'ga.gallery_id=gi.gallery_id',
	'ga.user_id=us.user_id',
	'ga.user_id=fu.user_id',
	'gi.file_hash=fu.file_hash',
	'gi.file_hash'	=> pudl::unhex($hash),
	'ga.gallery_id'	=> $id,
	cpnFilterBanned(),
]);
\af\affirm(404, $image);

$image['hash'] = bin2hex($image['file_hash']);




/////////////////////////////////////////////
// EXIF
/////////////////////////////////////////////
$tabs = ['exif' => ''];

$exif = $db->cell('pudl_file_meta', 'file_meta_value', [
	'file_hash'			=> pudl::unhex($hash),
	'file_meta_name'	=> 'exif',
]);

if (!empty($exif)) {
	$exif = preg_replace('/"html":.*""/', '"html":""', $exif);
	$exif = @json_decode($exif);
	if (!empty($exif)) {
		if (!empty($exif->FocalLength)) {
			$pos = strpos($exif->FocalLength, '/');
			if (!empty($pos)) {
				$exif->FocalLength = (int)substr($exif->FocalLength,0,$pos) / (int)substr($exif->FocalLength,$pos+1);
			}
		}
		$tabs['exif'] = $exif;
	}
}




/////////////////////////////////////////////
// COMMENTS
/////////////////////////////////////////////
$render['comment'] = $db->rows([
	'us' => _pudl_user(50),
	'cm' => 'pudl_comment',
], [
	'cm.commenter_id=us.user_id',
	'cm.file_hash'		=> pudl::unhex($hash),
	'cm.object_type_id'	=> $af->type('image'),
	cpnFilterBanned(),
], 'comment_timestamp');

foreach ($render['comment'] as &$item) {
	$item['timesince'] = \af\time::since( $item['comment_timestamp'] );
} unset($item);
$afurl->cdnAll($render['comment'], 'img', 'thumb_hash');

$render['newcomm'] = ['type'=>'image', 'id'=>$hash];




/////////////////////////////////////////////
// RENDER CONTENT
/////////////////////////////////////////////
$af->load('_virtual.tpl');
	$af->field('image',		$image);
	$af->field('tabs',		$tabs);
	$af->field('newcomm',	$render['newcomm']);
	$af->block('comment',	$render['comment']);
$af->render();
