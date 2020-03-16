<?php

$facebook = $db->rowId('pudl_user_facebook', 'pudl_user_id', $user['user_id']);
if (empty($facebook)) \af\error(422, 'No Facebook account linked to this user');



$id = $get->string('id');
if ($id < 1  ||  $id == $facebook['fb_user_id']) {
	$db->updateId('pudl_user_facebook', array(
		'fb_page_id'	=> NULL,
		'fb_page_name'	=> NULL,
		'fb_page_token'	=> NULL,
	), 'pudl_user_id', $user['user_id']);
	return;
}




require_once('_facebook/src/facebook.php');

$fbapi = new Facebook(array(
	'appId'  => $afconfig->facebook['id'],
	'secret' => $afconfig->facebook['secret'],
	'cookie' => false,
));

try {
	//	GET THE USER TOKEN
	$fbapi->setAccessToken($facebook['fb_auth_token']);

	$list = $fbapi->api("/$facebook[fb_user_id]/accounts", 'get');
	if (empty($list['data'])) \af\error(401);

	foreach ($list['data'] as $item) {
		if ($item['id'] == $id) {

			$db->updateId('pudl_user_facebook', [
				'fb_page_id'	=> $item['id'],
				'fb_page_name'	=> $item['name'],
				'fb_page_token'	=> $item['access_token'],
			], 'pudl_user_id', $user['user_id']);

			return;
		}
	}


} catch (FacebookApiException $e) {
	var_dump($e);
}
