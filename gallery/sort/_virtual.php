<?php

////////////////////////////////////////////////////////////////////////////////
//ONLY LOGGED IN USERS
////////////////////////////////////////////////////////////////////////////////
$user->requireLogin();




////////////////////////////////////////////////////////////////////////////////
//PULL DATA FROM REQUEST
////////////////////////////////////////////////////////////////////////////////
$gallery = $db->rowId('pudl_gallery', 'gallery_id', $router->id);
\af\affirm(404, $gallery);




////////////////////////////////////////////////////////////////////////////////
//TRANSACTIONS
////////////////////////////////////////////////////////////////////////////////
$db->begin();




////////////////////////////////////////////////////////////////////////////////
//SORT A USER PROFILE GALLERY - PROFILE OWNER ONLY
////////////////////////////////////////////////////////////////////////////////
if (!empty($gallery['user_id'])) {
	\af\affirm(401, $user->is($gallery));

	if ($af->prometheus()) {
		$items = $get->hashArray('cpn_photo');
	} else {
		$items = $get->hashArray('gallery-item');
	}

	foreach ($items as $key => $item) {
		$db->update('pudl_gallery_image', [
			'image_sort'	=> ((int)$key)+1
		], [
			'gallery_id'	=> $router->id,
			'file_hash'		=> pudl::unhex($item)
		]);
	}




////////////////////////////////////////////////////////////////////////////////
//SORT A TAG SHARED GALLERY - ADMIN ONLY
////////////////////////////////////////////////////////////////////////////////
} else if (!empty($gallery['group_id'])) {
	if ($user->isStaff()) {}
	else if ($db->clauseExists([
			'vm' => 'pudl_vendor_member',
			'pr' => 'pudl_product',
			'ol' => 'pudl_object_label',
			're' => 'pudl_group_relate',
		], [
			'pr.vendor_id=vm.vendor_id',
			'ol.object_id=pr.product_id',
			'vm.user_id'		=> $user['user_id'],
			'ol.object_type_id'	=> $af->type('product'),
			[
				['re.group_parent=ol.group_label_id',  're.group_child' => $gallery['group_id']],
				['re.group_child=ol.group_label_id',  're.group_parent' => $gallery['group_id']],
			]
		]
	)) {}
	else \af\error(401, 'Not a user gallery');

	$items = $get->stringArray('gallery-item');

	if ($gallery['gallery_type'] === 'youtube') {
		foreach ($items as $key => $item) {
			$db->update('pudl_gallery_video', [
				'youtube_sort'	=> ((int)$key)+1,
			], [
				'gallery_id'	=> $router->id,
				'youtube_id'	=> $item,
			]);
		}

	} else {
		foreach ($items as $key => $item) {
			$db->update('pudl_gallery_image', [
				'image_sort'	=> ((int)$key)+1,
			], [
				'gallery_id'	=> $router->id,
				'file_hash'		=> pudl::unhex($item),
			]);
		}
	}
}




////////////////////////////////////////////////////////////////////////////////
//TRANSACTIONS
////////////////////////////////////////////////////////////////////////////////
$db->commit();




////////////////////////////////////////////////////////////////////////////////
//CONFIRMATION BACK TO CLIENT
////////////////////////////////////////////////////////////////////////////////
$af->ok();
