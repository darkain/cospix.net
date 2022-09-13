<?php
$user->requireLogin();

$id = $get->id();

$image = $db->row(
	['ga'=>'pudl_gallery', 'ev'=>'pudl_event'],
	['ga.gallery_id'=>$id, 'ga.event_id=ev.event_id']
);
\af\affirm(404, $image);
\af\affirm(401, $user->is($image));




/////




$text = $get('text');
if (empty($text)) {
	$db->updateId('pudl_gallery', ['gathering_id'=>NULL], 'gallery_id', $id);
	return;
}




/////




$gathering = $db->row('pudl_gathering', [
	'gathering_name'	=> $text,
	'event_id'			=> $image['event_id'],
]);
\af\affirm(422, $gathering);




/////




$db->updateId('pudl_gallery', [
	'gathering_id' => $gathering['gathering_id']
], 'gallery_id', $id);

echo htmlspecialchars($get('text'));
