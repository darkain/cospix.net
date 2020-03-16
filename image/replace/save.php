<?php

$old = $get->hash('old');
$new = $get->hash('new');
if (empty($old) || empty($new) || $old===$new) \af\error(422);


$oldimg = $db->rowId('pudl_file', 'file_hash', pudl::unhex($old));
$newimg = $db->rowId('pudl_file', 'file_hash', pudl::unhex($new));
if (empty($oldimg) || empty($newimg)) \af\error(404);




////////////////////////////////////////////////////////////
//TRANSACTIONS!!
////////////////////////////////////////////////////////////
$db->begin();




$db->updateId('pudl_comment', [
	'file_hash' => pudl::unhex($new),
],	'file_hash', pudl::unhex($old));


$db->updateId('pudl_gallery', [
	'gallery_thumb' => pudl::unhex($new),
],	'gallery_thumb', pudl::unhex($old));


$db->updateId('pudl_gallery_image', [
	'file_hash' => pudl::unhex($new),
],	'file_hash', pudl::unhex($old));


$db->updateId('pudl_feature', [
	'file_hash' => pudl::unhex($new),
],	'file_hash', pudl::unhex($old));


$db->updateId('pudl_feature_submission', [
	'file_hash' => pudl::unhex($new),
],	'file_hash', pudl::unhex($old));


$db->updateIgnore('pudl_file_user', [
	'file_hash' => pudl::unhex($new),
], [
	'file_hash' => pudl::unhex($old),
]);


$db->updateIgnore('pudl_notification', [
	'file_hash' => pudl::unhex($new),
], [
	'file_hash' => pudl::unhex($old),
]);


$db->updateId('pudl_user', [
	'user_icon'	=> pudl::unhex($new),
],	'user_icon', pudl::unhex($old));

//TODO: THERE ARE A TON MORE TABLES TO UPDATE NOW!




////////////////////////////////////////////////////////////
//UPDATE CREDIT QUANTITY
////////////////////////////////////////////////////////////
$db->updateCount('pudl_file', 'file_credits', [
	'file_hash' => pudl::unhex($old),
], 'pudl_gallery_image');

$db->updateCount('pudl_file', 'file_credits', [
	'file_hash' => pudl::unhex($new),
], 'pudl_gallery_image');




////////////////////////////////////////////////////////////
//UPDATE FAVORITE QUANTITY
////////////////////////////////////////////////////////////
$db->updateCount('pudl_file', 'file_favorites', [
	'file_hash' => pudl::unhex($old),
], 'pudl_favorite');

$db->updateCount('pudl_file', 'file_favorites', [
	'file_hash' => pudl::unhex($new),
], 'pudl_favorite');




////////////////////////////////////////////////////////////
//TRANSACTIONS!!
////////////////////////////////////////////////////////////
$db->commit();
