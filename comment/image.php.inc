<?php



////////////////////////////////////////////////////////////
//UPDATE COMMENT QUANTITY
////////////////////////////////////////////////////////////
$db->updateCount('pudl_file', 'file_comments', [
	'file_hash' => pudl::unhex($hash),
], 'pudl_comment');




$mailheaders = [
	'to'		=> '',
];


$mailmessage = [
	'text'				=> "left a comment on your $type",
	'img'				=> $afurl->cdn($object['thumb_hash']),
	'url'				=> "/image/$hash",
	'user_url'			=> $user['user_url'],
	'user_thumb'		=> $user['img'],
	'user_name'			=> $user['user_name'],
	'notification_text' => afString::truncateword($text, 200),
];




////////////////////////////////////////////////////////////
//STEP 1: NOTIFY ALL OWNERS OF THIS IMAGE.
////////////////////////////////////////////////////////////

$rows = $db->rows([
	'fu' => 'pudl_file_user',
	'up' => 'pudl_user_preference',
	'uo' => 'pudl_user_profile',
	'us' => _pudl_user(50),
], [
	'fu.user_id=up.user_id',
	'up.user_id=uo.user_id',
	'us.user_id=uo.user_id',
	'fu.file_hash' => pudl::unhex($hash),
	cpnFilterBanned(),
]);

$owners = [];
foreach ($rows as $row) {
	//if the object is our own, nobody to notify!
	if ($user->is($row)) continue;

	$account = new afUser($db, $row);
	$owners[$account->user_id] = true;

	//verify notification settings for user
	$prefs = $account->getPreferences();

	if (!empty($prefs["cospix_$notice"])) {
		$db->insert('pudl_notification', [
			'file_hash'					=> pudl::unhex($hash),
			'object_type_id'			=> $af->type($type),
			'notification_user_from'	=> $user['user_id'],
			'notification_user_to'		=> $row['user_id'],
			'notification_timestamp'	=> $db->time(),
			'notification_read'			=> 0,
			'notification_text'			=> afString::truncateword($text, 100),
		], true);
	}


	//TODO: ADD TO EMAIL QUEUE FOR USER
	if (!empty($prefs["email_$notice"])  &&  \af\mail\validate($row['user_email'])) {
		$mailheaders['to'] = $row['user_email'];
		$row['img'] = $afurl->cdn($row, 'thumb_hash');
		if (empty($row['user_url'])) $row['user_url'] = $row['user_id'];

		$af->load('_cospix/email.tpl');
		$af->field('profile', $row);
		$af->field('message', $mailmessage);
		\af\mail($mailheaders, 'Cospix.net Notification', $af->renderToString());
	}
}




////////////////////////////////////////////////////////////
//STEP 2:	NOTIFY ALL OTHER COMMENTERS OF THIS IMAGE
//			IGNORE THOSE ARE ALREADY OWNERS
////////////////////////////////////////////////////////////

$mailmessage['text'] = "also commented on this $type";

$result = $db->group(
	'*',
	[
		'cm' => 'pudl_comment',
		'up' => 'pudl_user_preference',
		'uo' => 'pudl_user_profile',
		'us' => _pudl_user(50),
	],
	[
		'cm.file_hash'		=> pudl::unhex($hash),
		'cm.object_type_id'	=> $af->type($type),
		'cm.commenter_id=up.user_id',
		'up.user_id=uo.user_id',
		'us.user_id=uo.user_id',
		pudl::find('cm.comment_property', 'notify'),
		cpnFilterBanned(),
	],
	'cm.commenter_id'
);


while ($row = $result()) {
	//if the object is our own, nobody to notify!
	if ($user->is($row)) continue;

	$account	= new afUser($db, $row);
	$prefs		= $account->getPreferences();

	//ignoring $owners, because they're already notified above!
	if (isset($owners[$account->user_id])) continue;

	//verify notification settings for user
	if (!empty($prefs['cospix_commentreply'])) {
		$db->insert('pudl_notification', [
			'file_hash'					=> pudl::unhex($hash),
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
	if (!empty($prefs['email_commentreply'])  &&  \af\mail\validate($row['user_email'])) {
		$mailheaders['to'] = $row['user_email'];
		$row['img'] = $afurl->cdn($row, 'thumb_hash');
		if (empty($row['user_url'])) $row['user_url'] = $row['user_id'];

		$af->load('_cospix/email.tpl');
		$af->field('profile', $row);
		$af->field('message', $mailmessage);
		\af\mail($mailheaders, 'Cospix.net Notification', $af->renderToString());
	}
}

$result->free();
