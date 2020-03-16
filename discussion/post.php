<?php
////////////////////////////////////////////////////////////
// REQUIRE LOGIN
////////////////////////////////////////////////////////////
$user->requireLogin();




////////////////////////////////////////////////////////////
// VERIFY OBJECT
////////////////////////////////////////////////////////////
switch ($get->string('type')) {
	case 'event':
		$object = $db->rowId('pudl_event', 'event_group', $get->id());
	break;

	default: \af\error(422);
}

\af\affirm(404, $object);




////////////////////////////////////////////////////////////
// LOAD DATA
////////////////////////////////////////////////////////////
$text = $get->string('text');
if (empty($text)) return; //NOTHING TO PUBLISH!




////////////////////////////////////////////////////////////
// INSERT NEW DISCUSSION TOPIC!
////////////////////////////////////////////////////////////
$discussion_id = $db->insert('pudl_discussion', [
	'object_id'				=> $get->id(),
	'object_type_id'		=> $af->type( $get->string('type') ),
	'user_id'				=> $user['user_id'],
	'discussion_posted'		=> $db->time(),
	'discussion_updated'	=> $db->time(),
	'discussion_text'		=> $text,
]);

echo $discussion_id;




////////////////////////////////////////////////////////////
// NOTIFYING TAGGED USERS
////////////////////////////////////////////////////////////
preg_match_all('/(#)\[(\d+):([\w\s\.\-]+):([\w\s@\.,-\/#!$%\^&\*;:{}=\-_`~()]+)\]/i', $get->string('data'), $matches);
if (empty($matches[2])) return;

$tagged = [];
foreach ($matches[2] as $item) {
	$item = (int) $item;
	if ($user->is($item)) continue;
	if (!empty($tagged[$item])) continue;
	$tagged[$item] = true;
	if (!$db->clauseExists(['us'=>'pudl_user'], [cpnFilterBanned(), 'user_id'=>$item])) continue;

	//SEND NOTIFICATION TO TAGGED USER
	$db->insert('pudl_notification', [
		'object_id'					=> $discussion_id,
		'object_type_id'			=> $af->type('discussion'),
		'notification_user_to'		=> $item,
		'notification_user_from'	=> $user['user_id'],
		'notification_timestamp'	=> $db->time(),
		'notification_type'			=> 'mention',
		'notification_text'			=> afString::truncateword($text, 100),
	], true);
}
