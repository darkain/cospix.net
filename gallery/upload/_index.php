<?php


//TODO: REMOVE THIS ENTIRE FILE



$user->requireLogin();

$id			= $get->int('gallery_id');
$gallery	= $db->rowId(['ga'=>_cpnet_gallery(200)], 'gallery_id', $id);


\af\affirm(404, $gallery);
\af\affirm(401, $user->is($gallery));

$gallery['img'] =  $afurl->cdn($gallery, 'thumb_hash');


////////////////////////////////////////////////////////////////////////




Pel::setJPEGQuality(90);

if (empty($_FILES)) \af\error(401);

$good = array();
$err = false;

//NOTE: 12 byte minimum size pulled from PHP comments:
//      http://php.net/manual/en/function.exif-imagetype.php

foreach ($_FILES as $key => $file) {
	//TODO: OUTPUT ERRORS BACK TO BROWSER / USER
	if (empty($file['size']))					{ $err='No size';			continue; }
	if ($file['size'] < 12)						{ $err='Size too small';	continue; }
	if (empty($file['name']))					{ $err='No Name';			continue; }
	if (empty($file['tmp_name']))				{ $err='No File';			continue; }
	if (!empty($file['error']))					{ $err=$file['error'];		continue; }
	if (!is_uploaded_file($file['tmp_name']))	{ $err='Hacking?';			continue; }

	//Verify this is a GIF, JPEG, or PNG
	$file['type'] = exif_imagetype($file['tmp_name']);
	switch ($file['type']) {
		case IMAGETYPE_JPEG: $file['ext'] = 'jpg'; break;
		case IMAGETYPE_PNG:  $file['ext'] = 'png'; break;
		case IMAGETYPE_GIF:  $file['ext'] = 'gif'; break;
		default:
			$err = 'Invalid image';
			continue 2;
	}

	$import	= new \af\import($af, $db);
	$data	= $import->importImage($file['tmp_name'], $file);

	if (!empty($data['file_hash'])) {
		$data['img']  = $data[200]['file_url'];

		$good[] = $data + $gallery;



		////////////////////////////////////////////////////////////
		//INSERT DATA INTO DATABASE
		////////////////////////////////////////////////////////////
		$db->insert('pudl_gallery_image', [
			'file_hash'		=> $data['file_hash'],
			'gallery_id'	=> $id,
			'image_time'	=> $db->time(),
		], 'file_hash=file_hash');



		////////////////////////////////////////////////////////////
		//UPDATE CREDIT QUANTITY
		////////////////////////////////////////////////////////////
		$db->updateCount('pudl_file', 'file_credits', [
			'file_hash' => pudl::unhex($data['hash']),
		], 'pudl_gallery_image');
	}
}

\af\affirm(422, !$err, $err);
\af\affirm(422, $good, 'No files uploaded!');


//UPDATE ALBUM TIMESTAMPS
$update = ['gallery_timestamp' => $db->time()];

if (empty($gallery['gallery_thumb'])) $update['gallery_thumb'] = $data['file_hash'];

$db->updateId('pudl_gallery', $update, 'gallery_id', $gallery);


//ACTIVITY!!!
(new \af\activity($af, $user))->add($id, 'gallery', 'updated their ' . $gallery['gallery_type']);


$af->load('../gallery.tpl');
$af->block('g', $good);
$af->render();
