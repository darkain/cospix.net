<?php
require_once('comment/render.php.inc');
$user->requireLogin();



$db->begin();



////////////////////////////////////////////////////////////
//GET SHIT
////////////////////////////////////////////////////////////
$id		= $get->id();
$text	= $get->string('text', _GETVAR_BASIC);
$type	= $get->string('type');
$hash	= NULL;
if (empty($text)  ||  empty($type)) \af\error(422);




////////////////////////////////////////////////////////////
//VERIFY OBJECT EXISTS
////////////////////////////////////////////////////////////
$notice = false;
$object = false;

switch ($type) {
	case 'profile':
		$notice	= 'commentprofile';
		$object	= $db->row(['us'=>_pudl_user(200)], [
			'us.user_id' => $id,
			cpnFilterBanned(),
		]);
	break;


	case 'event':
		$notice	= 'commentreply';
		$object	= $db->row(['ev'=>_pudl_event(200)], [
			'ev.event_id' => $id
		]);
	break;


	case 'attending':
		$notice	= 'commentreply';
		$object	= $db->row(['ev'=>_pudl_event(200)], [
			'ev.event_id' => $id
		]);
	break;


	case 'gallery':
		$notice	= 'commentgallery';
		$object	= $db->row(['ga'=>_pudl_gallery(200)], [
			'ga.gallery_id' => $id
		]);
		//TODO: SUPPORT FILTER BAN HERE
		//$object	= $db->row(['us'=>_pudl_user(200)], ['us.user_id'=>$id,cpnFilterBanned()]);
	break;


	case 'article':
		$notice	= 'commentarticle';
		$object	= $db->rowId('pudl_article', 'article_id', $id);
		//TODO: SUPPORT FILTER BAN HERE
		//$object	= $db->row(['us'=>_pudl_user(200)], ['us.user_id'=>$id,cpnFilterBanned()]);
	break;


	case 'discussion':
		$notice	= 'commentdiscussion';
		$object	= $db->rowId('pudl_discussion', 'discussion_id', $id);
		$db->updateId('pudl_discussion', [
			'discussion_updated' => $db->time,
		], 'discussion_id', $id);
		//TODO: SUPPORT FILTER BAN HERE
		//$object	= $db->row(['us'=>_pudl_user(200)], ['us.user_id'=>$id,cpnFilterBanned()]);
	break;


	case 'comment':
		$notice	= 'commentreply';
		$object	= $db->rowId('pudl_comment', 'comment_id', $id);
		//TODO: SUPPORT FILTER BAN HERE
		//$object	= $db->row(['us'=>_pudl_user(200)], ['us.user_id'=>$id,cpnFilterBanned()]);
	break;


	case 'activity':
		$notice	= 'commentactivity';
		$object	= $db->rowId('pudl_activity', 'activity_id', $id);
		//TODO: SUPPORT FILTER BAN HERE
		//$object	= $db->row(['us'=>_pudl_user(200)], ['us.user_id'=>$id,cpnFilterBanned()]);
	break;


	case 'image':
		$notice	= 'commentphoto';
		$id		= 0;
		$hash	= $get->hash('id');
		$object	= $db->row(['fl'=>_pudl_file(200)], [
			'fl.file_hash' => pudl::unhex($hash),
		]);
	break;


	default:
		\af\error(422, 'Unknown object type');
		//TODO: ADD MORE OBJECT TYPES!!
}

\af\affirm(404, $object, strtoupper($type).' '.$id.' NOT FOUND');




////////////////////////////////////////////////////////////
//INSERT COMMENT
////////////////////////////////////////////////////////////
$comments = [[
	'file_hash'			=> empty($hash) ? NULL : pudl::unhex($hash),
	'object_id'			=> $id,
	'object_type_id'	=> $af->type($type),
	'commenter_id'		=> $user['user_id'],
	'comment_timestamp'	=> $db->time(),
	'comment_text'		=> $text,
]];

$comments[0]['comment_id']		= $db->insert('pudl_comment', $comments[0]);
$comments[0]['timesince']		= 'Now';
$comments[0]['comment_text']	= $text;
$comments[0] += $user->raw();




////////////////////////////////////////////////////////////
//RENDER
////////////////////////////////////////////////////////////
$af->renderBlock('comment.tpl', 'comment', $comments);


$db->commit();



////////////////////////////////////////////////////////////
//SEND NOTIFICATIONS
////////////////////////////////////////////////////////////

//test for image first, as it may contain user_id if linked to a gallery
if ($type === 'image') {
	require('image.php.inc');

//send notifications to object owner and other commenters
} else {
	require('object.php.inc');
}
