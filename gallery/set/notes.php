<?php
$user->requireLogin();


$image = $db->rowId('pudl_gallery', 'gallery_id', $get->id());
\af\affirm(404, $image);
\af\affirm(401, $user->is($image));



echo afString::linkify($get->string('text'));


$db->updateId('pudl_gallery', [
	'gallery_notes' => $get->string('text')
], 'gallery_id', $image);
