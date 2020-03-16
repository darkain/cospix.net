<?php
$user->requireLogin();

$id = $get->id();
$gallery = $db->row(
	['ga'=>'pudl_gallery', 'us'=>'pudl_user'],
	['gallery_id'=>$id, 'ga.user_id=us.user_id']
);

\af\affirm(404, $gallery);
\af\affirm(401, $user->is($gallery)  ||  $user->isStaff());


$type = $get->string('type');


if ($type === 'gallery'  &&  $gallery['gallery_type'] !== 'gallery') {
	//OK!!
} else if ($type === 'costume'  &&  $gallery['gallery_type'] !== 'costume') {
	//OK!!
} else {
	\af\error(422);
}


$db->updateId('pudl_gallery', [
	'gallery_type' => $type,
], 'gallery_id', $gallery);



if (empty($gallery['user_url'])) {
	echo "$afurl->base/$gallery[user_id]/$type/$id";
} else {
	echo "$afurl->base/$gallery[user_url]/$type/$id";
}
