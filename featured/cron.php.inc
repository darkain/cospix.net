<?php

require_once('_facebook/src/facebook.php');




////////////////////////////////////////////////////////////
//TRANSACTIONS!!
////////////////////////////////////////////////////////////
$db->begin();




////////////////////////////////////////////////////////////
//SELECT WINNER
////////////////////////////////////////////////////////////
$winner = $db->selectRow([
	'fs.*',
	'gi.*',
	'ga.*',
	'thumb_hash',
], [
	'fs' => 'pudl_feature_submission',
	'gi' => _pudl_gallery_image(1920),
	'ga' => 'pudl_gallery',
], [
	'fs.file_hash=gi.file_hash',
	'ga.gallery_id=gi.gallery_id',
	'ga.user_id=fs.user_id',
], [
	'vote_total'=>pudl::dsc()
]);

if (!empty($winner)) {
	$db->insert('pudl_feature', [
		'user_id'				=> $winner['user_id'],
		'file_hash'				=> $winner['file_hash'],
		'submission_timestamp'	=> $winner['submission_timestamp'],
		'feature_timestamp'		=> $db->time(),
		'vote_total'			=> $winner['vote_total'],
	]);

	$db->deleteId('pudl_feature_submission', 'submission_id', $winner);

	$text  = 'Photo of the Day for ' . date('F jS', $db->time()) . "\n\n";
	$text .= $afurl->host . $afurl->base . '/image/';
	$text .= bin2hex($winner['file_hash']) . '?gallery=' . $winner['gallery_id'];

	//Pull all credited users of the image
	$credits = $db->rows([
		'ga' => 'pudl_gallery',
		'gi' => 'pudl_gallery_image',
		'us' => 'pudl_user',
	], [
		'ga.gallery_id=gi.gallery_id',
		'ga.user_id=us.user_id',
		'gi.file_hash' => $winner['file_hash'],
		cpnFilterBanned(),
	]);

	//Activity!
	foreach ($credits as $credit) {
		(new \af\activity($af, $user))->addFile(
			$winner['file_hash'],
			'featured',
			'received',
			$credit
		);

		$text .= "\n\n";

		switch ($credit['gallery_role']) {
			case 'photo':		$text .= "Photographer: ";		break;
			case 'cosplay':		$text .= "Cosplayer: ";			break;
			case 'seamstress':	$text .= "Seamstress: ";		break;
			case 'wig':			$text .= "Wig/Hair Stylist: ";	break;
			case 'mua':			$text .= "Makeup Artist: ";		break;
			case 'prop':		$text .= "Prop Maker: ";		break;
			case 'accessory':	$text .= "Accessories: ";		break;
			case 'post':		$text .= "Post Production: ";	break;
			case 'assistant':	$text .= "Assistant: ";			break;
		}

		$text .= $credit['user_name'] . "\n";
		$text .= $afurl->host . $afurl->user($credit, true);
	}


	$facebook = new Facebook([
		'appId'		=> $afconfig->facebook['id'],
		'secret'	=> $afconfig->facebook['secret'],
		'cookie'	=> false,
	]);

	try {
		//	GET THE USER TOKEN
		$fbuser = $db->rowId('pudl_user_facebook', 'pudl_user_id', 1888);
		$facebook->setAccessToken($fbuser['fb_auth_token']);

		//	USE THE USER TOKEN TO GET PAGE ACCESS TOKEN
		$token = $facebook->api(
			'/'.$afconfig->facebook['page'],
			'get',
			['fields'=>'access_token']
		);

		if (!empty($token)) {
			$facebook->setAccessToken($token['access_token']);

			//	FIX URL OF IMAGE
			$cdn = $afurl->cdn($winner);
			if (substr($cdn, 0, 2) === '//') $cdn = 'http:' . $cdn;

			//	POST TO THE PAGE AS THE PAGE ITSELF
			$facebook->api(
				'/'.$afconfig->facebook['page'].'/photos/',
				'post',
				[
					'caption'	=> $text,
					'url'		=> $cdn,
				]
			);

			echo 'GOOD!';
		}

	} catch (FacebookApiException $e) {
		af_dump($e);
	}
}




////////////////////////////////////////////////////////////
//DELETE SUBMISSIONS OLDER THAN 20 DAYS
////////////////////////////////////////////////////////////
$db->delete('pudl_feature_submission', [
	'submission_timestamp' => pudl::lt( $db->time() - (AF_DAY*20) ),
]);




////////////////////////////////////////////////////////////
//TRANSACTIONS!! (FORCE NO SYNC, it is never needed for this)
////////////////////////////////////////////////////////////
$db->commit(false);
