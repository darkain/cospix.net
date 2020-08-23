<?php
return;

//TODO:	QUEUE IS CURRENTLY DISABLED, FACEBOOK DOESN'T LIKE US
//		POSTING SHIT THROUGH API ANYMORE!

/*
$time = $db->time() - (AF_MINUTE*5);



////////////////////////////////////////////////////////////
//LOAD FACEBOOK API
////////////////////////////////////////////////////////////
require_once('_facebook/src/facebook.php');

$facebook = new Facebook(array(
	'appId'  => $afconfig->facebook['id'],
	'secret' => $afconfig->facebook['secret'],
	'cookie' => false,
));





////////////////////////////////////////////////////////////
//LOAD QUEUE FROM DATABASE
////////////////////////////////////////////////////////////
$queue = $db->rows('pudl_queue', [
	'queue_time'	=> pudl::lt($time),
	'queue_service'	=> 'facebook',
]);




////////////////////////////////////////////////////////////
//PROCESS QUEUE
////////////////////////////////////////////////////////////
foreach ($queue as &$item) {
	//TODO: POSTPONE DELETE. IF ERROR, INCREMENT `RETRY` INSTEAD!!
	$db->delete('pudl_queue', [
		'queue_user'	=> $item['queue_user'],
		'queue_service'	=> $item['queue_service'],
		'queue_type'	=> $item['queue_type'],
	]);

	//Pull the user's current Facebook config
	$fbuser = $db->rowId('pudl_user_facebook', 'pudl_user_id', $item['queue_user']);
	if (empty($fbuser)) continue;


	//Decode message stored in database
	$attach = json_decode($item['queue_message'], true);

	//Singular vs Plural
	if ($item['queue_count'] > 1) {
		$attach['message'] = preg_replace('/\{\%1\}/', $item['queue_count'], $attach['message'], 1);
		$attach['message'] = preg_replace('/\{\%s\}/', 's', $attach['message'], 1);
	} else {
		$attach['message'] = preg_replace('/\{\%1\}/', 'a', $attach['message'], 1);
		$attach['message'] = preg_replace('/\{\%s\}/', '', $attach['message'], 1);
	}

	//No page selected, post to user's account
	if (empty($fbuser['fb_page_id'])) {
		$fbid = $fbuser['fb_user_id'];
		$facebook->setAccessToken($fbuser['fb_auth_token']);

	//Page selected, post to page instead of user's account
	} else {
		$fbid = $fbuser['fb_page_id'];
		$facebook->setAccessToken($fbuser['fb_page_token']);
	}

	//Attempt to post to Facebook
	try { $x = $facebook->api("/$fbid/feed/", 'post', $attach); }
	catch (FacebookApiException $e) { var_dump($e); }

} unset($item);
*/
