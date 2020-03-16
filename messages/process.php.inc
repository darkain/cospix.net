<?php

function process_message(&$message, $iconsize=50) {
	global $af, $afurl, $db, $user;

	//ALL SMALLER ICONS ARE NOW DEPRECATED
	$iconsize = 200;

	$message['class']		= $message['notification_read'] ? '' : 'cpn-message-new';
	$message['timesince']	= \af\time::since($message['notification_timestamp']);
	$message['properties']	= explode(',', $message['notification_property']);



	switch ($af->type($message['object_type_id'])) {

		case 'profile':
			$message['url'] = $afurl->user($message, true);
		break;



		case 'event':
			$message->merge($db->rowId(
				['ev' => _pudl_event($iconsize)],
				'event_id',
				$message
			));

			$message['object_name'] = $message['event_name'];

			$message['url'] = $afurl(['event', $message['event_name']], true);
		break;



		case 'gallery':
			$message->merge($db->rowId(
				['ga' => _pudl_gallery($iconsize)],
				'gallery_id',
				$message
			));

			$message['object_type'] = $message['gallery_type'];
			$message['object_name'] = $message['gallery_name'];
			$message['url'] = $afurl([$afurl->user($message), $message['object_type'], $message['object_id']], true);
		break;



		case 'image':
			$hash		= bin2hex($message['file_hash']);

			$message->merge($db->row([
				'fl' => _pudl_file($iconsize),
				'gi' => 'pudl_gallery_image',
				'ga' => 'pudl_gallery',
			], [
				'gi.file_hash=fl.file_hash',
				'ga.gallery_id=gi.gallery_id',
				'ga.user_id'	=> $user->id(),
				'fl.file_hash'	=> $message['file_hash'],
			]));

			if ($af->prometheus()) {
				$message['url'] = $afurl([$user, 'gallery', $message['gallery_id'], $hash], true);
			} else {
				$message['url'] = $afurl(['image',$hash], true) . '?gallery=' . $message['object_id'];
			}
		break;



		case 'favorite':
			$hash		= bin2hex($message['file_hash']);

			$message->merge($db->row([
				'fl' => _pudl_file($iconsize),
				'gi' => 'pudl_gallery_image',
				'ga' => 'pudl_gallery',
			], [
				'gi.file_hash=fl.file_hash',
				'ga.gallery_id=gi.gallery_id',
				'ga.user_id'	=> $user->id(),
				'fl.file_hash'	=> $message['file_hash'],
			]));

			if ($af->prometheus()) {
				$message['url']	= $afurl([$user, 'gallery', $message['gallery_id'], $hash], true);
			} else {
				$message['url']	= $afurl(['image',$hash], true) . '?gallery=' . $message['object_id'];
			}
			$message['text']	= 'added your photo to their favorites';
		break;



		case 'ask':
			$message['url']		= $afurl(['ask', $message['object_id']], true);
			$message['text']	= 'asked you a question';
		break;



		case 'answer':
			$message['url']		= $afurl(['ask', $message['object_id']], true);
			$message['text']	= 'answered your question';
		break;



		case 'follow':
			$message['url']		= $afurl->user($message, true);
			$message['text']	= 'is now following you';

			if (!$db->clauseExists('pudl_follow', [
				'user_id'	=> $user['user_id'],
				'follow_id'	=> $message['notification_user_from'],
			])) {
				$message['action'] = "cpn_follow(that)";
				$message['action_text'] = '+ Follow';
			}
		break;



		case 'tag':
			$hash				= bin2hex($message['file_hash']);

			$message->merge($db->row([
				'fl' => _pudl_file($iconsize),
				'gi' => 'pudl_gallery_image',
				'ga' => 'pudl_gallery',
				'us' => 'pudl_user',
			], [
				'us.user_id=ga.user_id',
				'gi.file_hash=fl.file_hash',
				'ga.gallery_id=gi.gallery_id',
				'ga.user_id'	=> $message['notification_user_from'],
				'fl.file_hash'	=> $message['file_hash'],
			]));

			if ($af->prometheus()) {
				$message['url']		= $afurl([$afurl->user($message), 'gallery', $message['object_id'], $hash], true);
			} else {
				$message['url']		= $afurl(['image',$hash], true) . '?gallery=' . $message['object_id'];
			}
			$message['text']		= 'credited you in an image';
			$message['action']		= "cpn_gallery_add(that,'$hash')";
			$message['action_text']	= 'Add To Galleries';
		break;



		case 'discussion':
			if ($message['notification_type'] == 'mention') {
				$message['text'] = 'tagged you in a discussion topic';
			} else {
				$message['text'] = 'commented on your discussion topic';
			}
			$discussion = $db->rowId('pudl_discussion', 'discussion_id', $message['object_id']);
			switch ($af->type($discussion['object_type_id'])) {
				case 'event':
					$event = $db->rowId('pudl_event', 'event_id', $discussion['object_id']);
					$message['url'] = $afurl(['event', $event['event_name'], 'discussion'], true);
				break;
			}
		break;



		default:
			$message['url'] = false;
	}



	if (empty($message['text'])) {
		if (in_array('reply', $message['properties'])) {
			if ($message['notification_type'] == 'mention') {
				$message['text'] = 'tagged you in a reply on the ' . $af->type($message['object_type_id']);
			} else {
				$message['text'] = 'also commented on the ' . $af->type($message['object_type_id']);
			}
		} else {
			if ($message['notification_type'] == 'mention') {
				$message['text'] = 'mentioned you in a comment on a ' . $af->type($message['object_type_id']);
			} else {
				$message['text'] = 'left a comment on your ' . $af->type($message['object_type_id']);
			}
		}
	}

}
