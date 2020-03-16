<?php
////////////////////////////////////////////////////////////
//DELETE AN ENTIRE GALLERY / COSTUME
//SEE /GALLERY/DELETE/ TO DELETE AN INDIVIDUAL IMAGE
////////////////////////////////////////////////////////////
$user->requireLogin();


//PULL GALLERY OBJECT
$gallery = $db->row(
	['ga'=>'pudl_gallery', 'us'=>'pudl_user'],
	['gallery_id'=>$get->id(), 'ga.user_id=us.user_id']
);
\af\affirm(404, $gallery);


//VERIFY OWNERSHIP
\af\affirm(401, $user->is($gallery));


//CONFIRM DELETE
if (!$get->int('confirm')) {
	$af->renderField('_index.tpl', 'gallery', $gallery);
	return;
}


//TRANSACTIONS
$db->begin();

//DELETE GALLERY
$db->deleteId('pudl_gallery', 'gallery_id', $gallery);

//BUILD CLAUSE FOR DELETE
$clause = [
	'object_id'			=> $gallery['gallery_id'],
	'object_type_id'	=> $af->type('gallery'),
];

//DELETE COMMENTS, NOTIFICATIONS, AND FEED ACTIVITY
$db->delete('pudl_comment',			$clause);
$db->delete('pudl_notification',	$clause);
$db->delete('pudl_activity',		$clause);

//TRANSACTIONS
$db->commit();
