<?php

if ($router->id === 2015) {
	$set = [60775, 61898, 60784, 60840, 61019, 61001, 59307];
} else if ($router->id === 2016) {
	$set = [98015, 93781, 94004, 94198, 94688, 95042, 96133, 94010, 96883, 101730, 108434];
} else {
	\af\error(404);
}



$af->title = 'Anime Expo ' . $router->id . ' Photo Booth';
$size = ($af->prometheus()) ? 500 : 200;




////////////////////////////////////////////////////////////
//PULL IMAGE DATA
////////////////////////////////////////////////////////////
$render['g'] = $db->select([
	'us.user_name',		'us.user_id',		'us.user_url',
	'th.thumb_hash',	'gi.file_hash',
	'ga.gallery_id',	'ga.gallery_name',
	'tx.file_width',	'tx.file_height',	'tx.mime_id',
], [
	'us' => 'pudl_user',
	'ga' => 'pudl_gallery',
	'gi' => _pudl_gallery_image($size),
], [
	'us.user_id=ga.user_id',
	'ga.gallery_id=gi.gallery_id',
	'ga.gallery_id'	=> $set,
], [
	'file_uploaded'=>pudl::dsc()
])->complete();




////////////////////////////////////////////////////////////
//NEW STYLE RENDERING
////////////////////////////////////////////////////////////
if ($af->prometheus()) {
	$photos = cpn_photo::manage($db, $render['g']);
	$photos->each(function($item){$item->user_name='';});

	$af->header();
	$photos->render($af);
	$af->footer();
	return;
}




////////////////////////////////////////////////////////////
//PROCESS ALL THE THINGS
////////////////////////////////////////////////////////////
$afurl->cdnAll($render['g'], 'img', 'thumb_hash');




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS
////////////////////////////////////////////////////////////
$af	->header()
		->load('_virtual.tpl')
			->block('g', $render['g'])
		->render()
	->footer();
