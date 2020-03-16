<?php


require_once('../profile.php.inc');




////////////////////////////////////////////////////////////////////////////////
//LOAD ALL THE CONTENTS!!
////////////////////////////////////////////////////////////////////////////////
$photos = cpn_photo::collect($db, [
	'column' => [
		'fu.user_time',
		'ga.gallery_id',
		'ga.gallery_name',
		'ga.gallery_type',
		'us.user_id',
		'us.user_url',
	],
	'table' => [
		'fu' => 'pudl_file_user',
		'gi' => 'pudl_gallery_image',
		'ga' => 'pudl_gallery',
		'us' => 'pudl_user',
	],
	'clause' => [
		'gi.file_hash=fu.file_hash',
		'ga.gallery_id=gi.gallery_id',
		'fu.file_hash=fl.file_hash',
		'us.user_id=fu.user_id',
		'ga.user_id=fu.user_id',
		'fu.user_id' => $profile->id(),
	],
	'group' => ['file_hash'],
	'order' => ['user_time' => pudl::desc()],
	'limit'	=> 100
]);




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
