<?php

$facebook = $db->rowId('pudl_user_facebook', 'pudl_user_id', $user['user_id']);
\af\affirm(422, $facebook, 'No Facebook account linked to this user');


require_once('_facebook/src/facebook.php');

$fbapi = new Facebook([
	'appId'  => $afconfig->facebook['id'],
	'secret' => $afconfig->facebook['secret'],
	'cookie' => false,
]);


$fbpages = array();

try {
	//	GET THE USER TOKEN
	$fbapi->setAccessToken($facebook['fb_auth_token']);

	//https://graph.facebook.com/me/accounts
	//TODO: if a user skips PAGE authorization, this will BREAK!
	$list = $fbapi->api("/$facebook[fb_user_id]/accounts", 'get');
	if (!empty($list['data'])) $fbpages = $list['data'];
/*
	//	USE THE USER TOKEN TO GET PAGE ACCESS TOKEN
	$token = $fbapi->api("/$site[fb_page_id]", 'get', array('fields'=>'access_token'));
	if (empty($token)) die('UNABLE TO GET TOKEN FOR PAGE');
	$fbapi->setAccessToken($token['access_token']);

	//	POST TO THE PAGE AS THE PAGE ITSELF
	//$fbapi->api("/$site[fb_page_id]/feed/", 'post', $attachment);
*/
} catch (FacebookApiException $e) {
	var_dump($e);
	exit;
}

$af->load('page.tpl');
	$af->field('fbuser', $facebook);
	$af->block('fbpage', $fbpages);
$af->render();
