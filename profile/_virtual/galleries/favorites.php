<?php


require_once('../profile.php.inc');




////////////////////////////////////////////////////////////////////////////////
//LOAD ALL THE CONTENTS!!
////////////////////////////////////////////////////////////////////////////////
$photos = cpn_photo::collect($db, [
	'column' => [
		'ga.*',
		'us.user_id',
		'us.user_name',
		'us.user_url',
		'user_time' => 'favorite_timestamp',
	],
	'table' => [
		'fa' => 'pudl_favorite',
		'us' => 'pudl_user',
		'ga' => 'pudl_gallery',
	],
	'clause' => [
		cpnFilterBanned(),
		'fa.user_id' => $profile->user_id,
		'fa.file_hash=fl.file_hash',
		'ga.gallery_id=fa.gallery_id',
		'ga.user_id=us.user_id',
	],
	'order' => ['favorite_timestamp' => pudl::desc()],
	//TODO: LIMIT AND INFINITE SCROLLER
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
