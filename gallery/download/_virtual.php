<?php

\af\affirm(404,
	$image = $db->row([
		'fi'=>'pudl_file',
		'mt'=>'pudl_mimetype'
	], [
		'file_hash' => pudl::unhex($router->virtual[0]),
		'fi.mime_id=mt.mime_id',
	])
);


//TODO: SANATAIZE FILE NAME

header('Content-Description: File Transfer');
header('Content-Type: ' . $image['mime_type']);
header('Content-Disposition: attachment; filename=' . $image['file_name']);
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . $image['file_size']);
readfile($afurl->cdn($router->virtual[0]));
exit;
