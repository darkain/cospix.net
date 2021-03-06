<?php
$user->requireLogin();




$name = $get->string('name');
if (empty($name)) return;

//TODO: BUILD A LIST OF NON-ACCEPTABLE CHARACTERS TO BLOCK IN NAMES




////////////////////////////////////////////////////////////////////////////////
//TRANSACTIONS
////////////////////////////////////////////////////////////////////////////////
$db->begin();




////////////////////////////////////////////////////////////////////////////////
//CHECK IF EVENT NAME EXISTS
////////////////////////////////////////////////////////////////////////////////
$event = $db->selectRow(
	'*',
	'pudl_event',
	['event_name' => pudl::like($name)],
	['event_start'=>pudl::dsc()]
);
$event_id = empty($event['event_id']) ? NULL : $event['event_id'];




////////////////////////////////////////////////////////////////////////////////
//GALLERY ROLE
////////////////////////////////////////////////////////////////////////////////
$role = '';

if ($af->prometheus()) {
	switch ($get('role')) {
		case 'create':
		case 'cosplay':
		case 'photo':
			$role = $get('role');
	}
} else {
	$role = 'photo';
}




////////////////////////////////////////////////////////////////////////////////
//CREATE NEW GALLERY
////////////////////////////////////////////////////////////////////////////////
$id = $db->insert('pudl_gallery', [
	'gallery_type'		=> 'gallery',
	'gallery_role'		=> $role,
	'user_id'			=> $user['user_id'],
	'gallery_timestamp'	=> $db->time(),
	'gallery_name'		=> $name,
	'event_id'			=> $event_id,
]);

\af\affirm(422, $id, 'Unable to create gallery');




////////////////////////////////////////////////////////////////////////////////
//UPDATE GALLERY SORT ORDER
////////////////////////////////////////////////////////////////////////////////
$db->incrementId('pudl_gallery', 'gallery_sort', $user);




////////////////////////////////////////////////////////////////////////////////
//ACTIVITY!!!
////////////////////////////////////////////////////////////////////////////////
(new \af\activity($af, $user))->add($id, 'gallery', 'added a new gallery');




////////////////////////////////////////////////////////////////////////////////
//TRANSACTIONS
////////////////////////////////////////////////////////////////////////////////
$db->commit();




////////////////////////////////////////////////////////////////////////////////
//REDIRECT
//TODO: SWITCH THIS OVER TO NEW REDIRECT SYSTEM!
////////////////////////////////////////////////////////////////////////////////
//if ($af->prometheus()) {
//	$afurl->redirect([$user, 'gallery', $id]);
//} else {
	echo "$afurl->base/$user[user_url]/gallery/$id";
//}
