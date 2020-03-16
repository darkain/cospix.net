<?php
$user->requireLogin();




$hash = $get->hash();


//TRANSACTIONS!!
$db->begin();




////////////////////////////////////////////////////////////////////////////////
//LOAD THE IMAGE
////////////////////////////////////////////////////////////////////////////////
\af\affirm(404,
	$image = $db->row([
		'fu' => 'pudl_file_user',
	], [
		'fu.file_hash'	=> pudl::unhex($hash),
		'fu.user_id'	=> $user['user_id'],
	])
);




//ADD THE IMAGE TO GALLERIES
$items = $get->intArray('gallery');

foreach ($items as $item) {
	$gallery = $db->selectRow([
		'gi.*', 'ga.*'
	],[
		'ga' => ['pudl_gallery', [
			'left' => ['gi' => 'pudl_gallery_image'], 'on' => [
				'ga.gallery_id=gi.gallery_id',
				'gi.file_hash' => pudl::unhex($hash)
			]
		]
	]], [
		'ga.user_id'	=> $user['user_id'],
		'ga.gallery_id'	=> $item,
	]);

	if (empty($gallery)) continue;
	if (!empty($gallery['file_hash'])) continue;




	////////////////////////////////////////////////////////////////////////////
	//LINK IMAGE TO GALLERY
	////////////////////////////////////////////////////////////////////////////
	$db->insert('pudl_gallery_image', [
		'file_hash'		=> pudl::unhex($hash),
		'gallery_id'	=> $gallery['gallery_id'],
		'image_time'	=> $db->time(),
	], 'file_hash=file_hash');




	////////////////////////////////////////////////////////////////////////////
	//UPDATE CREDIT QUANTITY
	////////////////////////////////////////////////////////////////////////////
	$db->updateCount('pudl_file', 'file_credits', [
		'file_hash' => pudl::unhex($hash),
	], 'pudl_gallery_image');




	////////////////////////////////////////////////////////////////////////////
	//UPDATE THE ALBUM TIMESTAMP AND THUMBNAIL
	////////////////////////////////////////////////////////////////////////////
	$update = ['gallery_timestamp' => $db->time()];

	if (empty($gallery['gallery_thumb'])) {
		$update['gallery_thumb'] = pudl::unhex($hash);
	}

	$db->updateId('pudl_gallery', $update, 'gallery_id', $item);




	////////////////////////////////////////////////////////////////////////////
	//ADD ACTIVITY ITEM TO FEED
	////////////////////////////////////////////////////////////////////////////
	(new \af\activity($af, $user))->add(
		$gallery['gallery_id'],
		'gallery',
		'updated their ' . $gallery['gallery_type']
	);
}



//DELETE IMAGE FROM UNSELECTED GALLERIES
$items[] = 0;
$db->delete('pudl_gallery_image', [
	'file_hash'		=> pudl::unhex($hash),
	'gallery_id'	=> $db->in()->select(
		'gallery_id',
		'pudl_gallery',
		['user_id'=>$user['user_id']]
	),
	['gallery_id' => pudl::notInSet($items)],
]);


//TRANSACTIONS!!
$db->commit();
