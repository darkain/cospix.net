<?php


require_once('../profile.php.inc');




////////////////////////////////////////////////////////////////////////////////
//LOAD ALL THE CONTENTS!!
////////////////////////////////////////////////////////////////////////////////
$photos = cpn_photo::collect($db, [
	'column' => [
		'ga.*',
		'us.*',
		'ac.*',
	],
	'table' => [
		'ac' => 'pudl_activity',
		'us' => 'pudl_user',
		'ga' => 'pudl_gallery',
		'gi' => 'pudl_gallery_image',
	],
	'clause' => [
		cpnFilterBanned(),
		'gi.gallery_id=ga.gallery_id',
		'ac.file_hash=fl.file_hash',
		'ac.file_hash=gi.file_hash',
		'ga.user_id=us.user_id',
		'ac.user_id=us.user_id',
		'us.user_id'		=> $profile->id(),
		'ac.object_type_id'	=> $af->type('featured'),
	],
	'order' => ['activity_timestamp' => pudl::desc()],
	//TODO: LIMIT AND INFINITE SCROLLER
]);

foreach ($photos as $photo) {
	$photo->name = date('F jS, Y', $photo->activity_timestamp);
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
