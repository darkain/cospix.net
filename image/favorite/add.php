<?php

$user->requireLogin();




////////////////////////////////////////////////////////////
//TRANSACTIONS
////////////////////////////////////////////////////////////
$db->begin();




////////////////////////////////////////////////////////////
//PULL IMAGE DATA
////////////////////////////////////////////////////////////
\af\affirm(404,
	$image = $db->row([
		'gi' => 'pudl_gallery_image',
		'ga' => 'pudl_gallery',
	], [
		'gi.gallery_id=ga.gallery_id',
		'gi.gallery_id'			=> $get->id(),
		'gi.file_hash'			=> $get->binary(),
	])
);




////////////////////////////////////////////////////////////
//INSERT NEW FAVORITE INTO DATABASE
////////////////////////////////////////////////////////////
$db->insert('pudl_favorite', [
	'user_id'					=> $user['user_id'],
	'file_hash'					=> $get->binary(),
	'gallery_id'				=> $image['gallery_id'],
	'favorite_timestamp'		=> $db->time(),
], 'file_hash=file_hash');




////////////////////////////////////////////////////////////
//INSERT NEW NOTIFICATION FOR FAVORITE INTO DATABASE
////////////////////////////////////////////////////////////
$db->insert('pudl_notification', [
	'file_hash'					=> $get->binary(),
	'object_id'					=> $image['gallery_id'],
	'object_type_id'			=> $af->type('favorite'),
	'notification_user_from'	=> $user['user_id'],
	'notification_user_to'		=> $image['user_id'],
	'notification_timestamp'	=> $db->time(),
], 'file_hash=file_hash');




////////////////////////////////////////////////////////////
//UPDATE FAVORITE QUANTITY
////////////////////////////////////////////////////////////
$db->updateCount('pudl_file', 'file_favorites', [
	'file_hash'					=> $get->binary(),
], 'pudl_favorite');




//TODO: ADD FEED ITEM TO CURRENT USER



////////////////////////////////////////////////////////////
//TRANSACTIONS
////////////////////////////////////////////////////////////
$db->commit();




////////////////////////////////////////////////////////////
//OUTPUT TEXT
////////////////////////////////////////////////////////////
echo file_get_contents('../../static/svg/heart.svg');
echo ' Remove from Favs';
