<?php

$user->requireLogin();




////////////////////////////////////////////////////////////
//TRANSACTIONS
////////////////////////////////////////////////////////////
$db->begin();




////////////////////////////////////////////////////////////
//DELETE FAVORITE FROM DATABASE
////////////////////////////////////////////////////////////
$db->delete('pudl_favorite', [
	'user_id'	=> $user['user_id'],
	'file_hash'	=> pudl::unhex($get->hash()),
]);




////////////////////////////////////////////////////////////
//UPDATE FAVORITE QUANTITY
////////////////////////////////////////////////////////////
$db->updateCount('pudl_file', 'file_favorites', [
	'file_hash' => pudl::unhex($get->hash()),
], 'pudl_favorite');



//TODO: REMOVE NOTIFICATIONS ALL CREDITED USERS IN THE IMAGE
//TODO: REMOVE FEED ITEM FROM CURRENT USER



////////////////////////////////////////////////////////////
//TRANSACTIONS
////////////////////////////////////////////////////////////
$db->commit();




////////////////////////////////////////////////////////////
//OUTPUT TEXT
////////////////////////////////////////////////////////////
echo file_get_contents('../../static/svg/heart.svg');
echo ' Add to Favs';
