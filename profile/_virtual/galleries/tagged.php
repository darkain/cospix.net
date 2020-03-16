<?php


require_once('../profile.php.inc');




////////////////////////////////////////////////////////////////////////////////
//LOAD ALL THE CONTENTS!!
////////////////////////////////////////////////////////////////////////////////
$photos = cpn_photo::collect($db, [
	'column' => [
		'us.user_id',
		'us.user_name',
		'us.user_url',
		'fu.user_time',
		'ga.gallery_id',
		'ga.gallery_name',
		'ga.gallery_type',
	],
	'table' => [
		'us' => 'pudl_user',
		'fu' => 'pudl_file_user',
		'gi' => 'pudl_gallery_image',
		'ga' => 'pudl_gallery',
	],
	'clause' => [
		'gi.file_hash=fu.file_hash',
		'ga.gallery_id=gi.gallery_id',
		'fu.file_hash=fl.file_hash',
		'ga.user_id=us.user_id',
		'fu.user_id' => $profile->id(),
		'ga.user_id' => pudl::neq($profile->id()),
	],
	'group' => ['file_hash'],
	'order' => ['user_time' => pudl::desc()],
	'limit'	=> 100 //TODO: infinite scroller!
]);

foreach ($photos as $photo) {
	$photo->name = $photo->gallery_name;
}




////////////////////////////////////////////////////////////////////////////////
//EMPTY RESULT SET
////////////////////////////////////////////////////////////////////////////////
if (!$photos->count()) {
	$photos[] = new cpn_custom($db, 'galleries/empty.tpl');
}




////////////////////////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////////////////////////
$photos->render($af);
