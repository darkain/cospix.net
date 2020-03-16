<?php
$user->requireLogin();


$gallery = $db->rowId('pudl_gallery', 'gallery_id', $get->id());
\af\affirm(404, $gallery);
\af\affirm(401, $user->is($gallery)  ||  $user->isStaff());


echo $get->string('text');


$db->updateId('pudl_gallery', [
	'gallery_name' => $get->string('text')
], 'gallery_id', $gallery);
