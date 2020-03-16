<?php


////////////////////////////////////////////////////////////
//STEP 1: NOTIFY THE OWNER OF THIS OBJECT.
////////////////////////////////////////////////////////////
$owners = array();
if (!empty($object['user_id'])  &&  !$user->is($object)) {
	$owners[ $object['user_id'] ] = true;

	//verify notification settings for user
	$account	= new afUser($db, $object);
	$prefs		= $account->getPreferences();

	if (!empty($prefs["cospix_$notice"])) {
		$db->insert('pudl_notification', [
			'object_id'					=> $id,
			'object_type_id'			=> $af->type($type),
			'notification_user_from'	=> $user['user_id'],
			'notification_user_to'		=> $object['user_id'],
			'notification_timestamp'	=> $db->time(),
			'notification_read'			=> 0,
			'notification_text'			=> afString::truncateword($text, 100),
		], true);
	}
}




////////////////////////////////////////////////////////////
//STEP 2:	NOTIFY ALL OTHER COMMENTERS OF THIS IMAGE
//			IGNORE THOSE ARE ALREADY OWNERS
////////////////////////////////////////////////////////////

$result = $db->group(
	['user_id'=>'commenter_id', 'preference'],
	['cm'=>'pudl_comment', 'up'=>'pudl_user_preference', 'us'=>'pudl_user'],
	[
		'object_id'			=> $id,
		'object_type_id'	=> $af->type($type),
		'cm.commenter_id=up.user_id',
		'us.user_id=up.user_id',
		pudl::find('cm.comment_property', 'notify'),
		cpnFilterBanned(),
	],
	'commenter_id'
);


while ($row = $result()) {

	//ignoring $owners, because they're already notified above!
	if (isset($owners[ $row['user_id'] ])) continue;

	//if the object is our own, nobody to notify!
	if ($user->is($row)) continue;

	//verify notification settings for user
	$account	= new afUser($db, $row);
	$prefs		= $account->getPreferences();

	if (!empty($prefs["cospix_$notice"])) {
		$db->insert('pudl_notification', [
			'object_id'					=> $id,
			'object_type_id'			=> $af->type($type),
			'notification_user_from'	=> $user['user_id'],
			'notification_user_to'		=> $row['user_id'],
			'notification_timestamp'	=> $db->time(),
			'notification_property'		=> 'reply',
			'notification_read'			=> 0,
			'notification_text'			=> afString::truncateword($text, 100),
		], true);
	}

	//TODO: ADD TO EMAIL QUEUE FOR USER
}

$result->free();
