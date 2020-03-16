<?php



$import		= new \af\import($af, $db);
$thumbsize	= $import->smallest;
$_GET['jq']	= 1; //disable fancy error reports




////////////////////////////////////////////////////////////////////////////////
//ONLY ALLOW 1 FILE TO UPLOAD AT A TIME, FOR NOW
////////////////////////////////////////////////////////////////////////////////
if (empty($_FILES))		\af\error(404, 'Nothing to process');
if (count($_FILES) > 1)	\af\error(422, 'Too many files to process. Maximum: 1');
if (count($_FILES) < 1)	\af\error(422, 'No files to process');




////////////////////////////////////////////////////////////////////////////////
//HASH FILE
////////////////////////////////////////////////////////////////////////////////
$file = reset($_FILES);
$file['hash'] = @md5_file($file['tmp_name'], true);




////////////////////////////////////////////////////////////////////////////////
//TRANSACTION
////////////////////////////////////////////////////////////////////////////////
$db->begin();




////////////////////////////////////////////////////////////////////////////////
//VERIFY GALLERY EXIST
////////////////////////////////////////////////////////////////////////////////
$gallery_id	= $get->id('gallery_id');
if ($gallery_id) {
	\af\affirm(404,
		$gallery = $db->rowId('pudl_gallery', 'gallery_id', $gallery_id),
		'Invalid Gallery ID'
	);
}




////////////////////////////////////////////////////////////////////////////////
//VERIFY EVENT EXIST
////////////////////////////////////////////////////////////////////////////////
$event_id	= $get->id('event_id');
if ($event_id) {
	\af\affirm(404,
		$event = $db->rowId('pudl_event', 'event_id', $event_id),
		'Invalid Event ID'
	);
}




////////////////////////////////////////////////////////////////////////////////
//VERIFY ONE OR THE OTHER EXISTS
////////////////////////////////////////////////////////////////////////////////
if (empty($gallery_id)  &&  empty($event_id)) {
	\af\error(404, 'No gallery specified for uploaded image');
}




////////////////////////////////////////////////////////////////////////////////
//IS THIS A BRAND NEW GALLERY?
////////////////////////////////////////////////////////////////////////////////
if (empty($gallery_id)) {
	//Do we already have a gallery for this event?
	$gallery = $db->row('pudl_gallery', [
		'user_id'				=> $user['user_id'],
		'event_id'				=> $event['event_id'],
		'gallery_name'			=> $event['event_name'],
		'gallery_type'			=> 'gallery',
	]);

	if (empty($gallery)) {
		$gallery_id = $db->insert('pudl_gallery', [
			'gallery_type'		=> 'gallery',
			'gallery_role'		=> 'photo',
			'user_id'			=> $user['user_id'],
			'event_id'			=> $event['event_id'],
			'gallery_timestamp' => $db->time(),
			'gallery_name'		=> $event['event_name'],
		]);

		if (empty($gallery_id)) \af\error(422, 'ERROR CREATING GALLERY');

		//UPDATE GALLERY SORT ORDER
		$db->incrementId('pudl_gallery', 'gallery_sort', 'user_id', $user);

		//PULL NEW GALLERY DATA
		$gallery = $db->rowId('pudl_gallery', 'gallery_id', $gallery_id);
	}

	\af\affirm(500, $gallery, 'Unable to create new gallery');
}




////////////////////////////////////////////////////////////////////////////////
//VERIFY WE'RE DEALING WITH AN IMAGE GALLERY, NOT VIDEO
////////////////////////////////////////////////////////////////////////////////
\af\affirm(422,
	in_array($gallery['gallery_type'], ['gallery','costume']),
	'Invalid Gallery Type - Only type [gallery] or [costume] supported'
);




////////////////////////////////////////////////////////////////////////////////
//VERIFY GALLERY PERMISSIONS
////////////////////////////////////////////////////////////////////////////////
if (empty($gallery['user_id'])) {
	if ($user->isStaff()) {
		//we're good!
	} else if ($db->clauseExists([
			'vm' => 'pudl_vendor_member',
			'pr' => 'pudl_product',
			'ol' => 'pudl_product_label',
			're' => 'pudl_group_relate',
		],[
			'pr.vendor_id=vm.vendor_id',
			'ol.object=pr.product_id',
			'ol.object_type_id'	=> $af->type('product'),
			'vm.user_id'		=> $user['user_id'],
			[
				//TODO: FIX THIS!!
				['re.group_parent=ol.group_label_id', 're.group_child'=>$gallery['group_id']],
				['re.group_child=ol.group_label_id', 're.group_parent'=>$gallery['group_id']],
			]
		]
	)) {
		//we're good!
	} else {
		\af\error(401, 'Not a user gallery');
	}

} else if (!$user->is($gallery)) {
	\af\error(401, 'You do not have permission to upload to this gallery');
}




////////////////////////////////////////////////////////////////////////////////
//CHECK IF HASH EXISTS AS AN EXISTING IMAGE FILE
////////////////////////////////////////////////////////////////////////////////
$image = $db->row([
	'fl'=>'pudl_file',
	'th'=>'pudl_file_thumb'
], [
	'fl.file_hash=th.file_hash',
	'fl.file_hash'	=> $file['hash'],
	'th.thumb_type'	=> (string) $thumbsize, //INTENTIONALLY STRING
]);




////////////////////////////////////////////////////////////////////////////////
//CHECK IF HASH EXISTS AS AN EXISTING THUMBNAIL
////////////////////////////////////////////////////////////////////////////////
if (empty($image)) $image = $db->selectRow(
	['fl.*', 'th2.thumb_hash'],
	['fl'=>'pudl_file', 'th1'=>'pudl_file_thumb', 'th2'=>'pudl_file_thumb'],
	[
		'fl.file_hash=th1.file_hash',
		'fl.file_hash=th2.file_hash',
		'th2.thumb_type'	=> (string) $thumbsize, //INTENTIONALLY STRING
		'th1.thumb_hash'	=> $file['hash'],
	]
);




////////////////////////////////////////////////////////////////////////////////
//PROCESS IMAGE AND UPDATE DATABASE
////////////////////////////////////////////////////////////////////////////////
if (empty($image)) {
	$image	= $import->upload();

	$image['thumb_hash'] = $image[$thumbsize]['hash'];

} else {
	$db->insert('pudl_file_user', [
		'file_hash'			=> $image['file_hash'],
		'user_id'			=> $user['user_id'],
		'user_time'			=> $db->time(),
	], 'file_hash=file_hash');
}




////////////////////////////////////////////////////////////////////////////////
//INSERT EXIF DATA
////////////////////////////////////////////////////////////////////////////////
if (!empty($image['exif'])) {
	$set = [
		'camera'	=> 'Model',
		'lens'		=> 'LensModel',
		'software'	=> 'Software',
	];

	//Insert Tags
	foreach ($set as $key => $val) {
		if (!empty($image['exif'][$val])) {
			$tag = cpnTag::insertLabel($image['exif'][$val], $key);
			if ($tag) cpnTag::insertHash($image['file_hash'], 'image', $tag);
		}
	}
}




////////////////////////////////////////////////////////////////////////////////
//UPDATE GALLERY SORT ORDER
////////////////////////////////////////////////////////////////////////////////
$db->incrementId(
	'pudl_gallery_image',
	'image_sort',
	'gallery_id', $gallery['gallery_id']
);




////////////////////////////////////////////////////////////////////////////////
//INSERT IMAGE INTO GALLERY
////////////////////////////////////////////////////////////////////////////////
$db->insert('pudl_gallery_image', [
	'file_hash'		=> $image['file_hash'],
	'gallery_id'	=> $gallery['gallery_id'],
	'image_time'	=> $db->time(),
], 'file_hash=file_hash');




////////////////////////////////////////////////////////////////////////////////
//UPDATE CREDIT QUANTITY
////////////////////////////////////////////////////////////////////////////////
$db->updateCount('pudl_file', 'file_credits', [
	'file_hash' => $image['file_hash'],
], 'pudl_gallery_image');




////////////////////////////////////////////////////////////////////////////////
//UPDATE THE ALBUM TIMESTAMP AND THUMBNAIL
////////////////////////////////////////////////////////////////////////////////
$update = ['gallery_timestamp' => $db->time()];

if (empty($gallery['gallery_thumb'])) {
	$update['gallery_thumb'] = $image['file_hash'];
}

$db->updateId('pudl_gallery', $update, 'gallery_id', $gallery);




////////////////////////////////////////////////////////////////////////////////
//ADD ACTIVITY ITEM TO FEED
////////////////////////////////////////////////////////////////////////////////
(new \af\activity($af, $user))->add(
	$gallery['gallery_id'],
	'gallery',
	'updated their ' . $gallery['gallery_type']
);




////////////////////////////////////////////////////////////////////////////////
//FINAL RENDER OF THE IMAGE
////////////////////////////////////////////////////////////////////////////////
$image['img']		= $afurl->cdn($image['thumb_hash']);

if (empty($image['hash'])) {
	$image['hash']	= bin2hex($image['file_hash']);
}

$image += $gallery;

if ($af->prometheus()) {
	//TODO:	upload script shouldnt use objects anymore for file_hash
	//		fix that in Altaform
	//TODO:	UPLOAD SCRIPTS SHOULD RETURN IMAGE URLS WITH FILE EXTENSIONS!!
	$image['file_hash'] = hex2bin($image['hash']);
	$photo = new cpn_photo($db, $image);
	$photo->user_id		= $user->user_id;
	$photo->user_url	= $user->user_url;
	$photo->name		= '';
	$photo->render($af);

} else {
	$af->load('gallery/gallery.tpl')->block('g', [$image])->render();
}




////////////////////////////////////////////////////////////////////////////////
//TRANSACTION
////////////////////////////////////////////////////////////////////////////////
$db->commit();
