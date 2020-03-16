<?php


////////////////////////////////////////////////////////////////////////////////
//VERIFY CREDENTIALS
////////////////////////////////////////////////////////////////////////////////
if (\af\cli()) {
	\af\affirm(404, count($argv)>2);
	$hash = @hex2bin($argv[2]);
} else {
	$user->requireAdmin();
	$hash = pudl::unhex($get->hash());
}




////////////////////////////////////////////////////////////////////////////////
//PULL IMAGE DATE
////////////////////////////////////////////////////////////////////////////////
$image = $db->rowId('pudl_file', 'file_hash', $hash);
\af\affirm(404, $image, $db->query());




////////////////////////////////////////////////////////////////////////////////
//DELETE IMAGE AND THUMBNAILS FROM DISK AND DATABASE
////////////////////////////////////////////////////////////////////////////////
if ($get->bool('confirm')  ||  \af\cli()) {
	$db->begin();

	$thumbs = $db->rowsId('pudl_file_thumb', 'file_hash', $hash);
	$db->deleteId('pudl_file', 'file_hash', $hash);

	//DELETE BASE IMAGE
	$path = $afurl->cdnPath($image['file_hash']);
	echo $path . "<br/><br/>\n\n";
	@unlink($path);

	foreach ($thumbs as $thumb) {
		//DELETE THUMB IMAGE
		$path = $afurl->cdnPath($thumb['thumb_hash']);
		echo $path . "<br/><br/>\n\n";
		@unlink($path);
	}

	$db->commit();
	return;
}



$af->renderField('nuke.tpl', 'image', $image);
