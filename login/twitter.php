<?php


if ($user->loggedIn()) {
	require('redirect.php.inc');
}


require_once('_oauth/http.php');
require_once('_oauth/oauth_client.php');

$oauth = new oauth_client_class;
$oauth->server			= 'Twitter';
$oauth->client_id		= $afconfig->twitter['id'];
$oauth->client_secret	= $afconfig->twitter['secret'];
$oauth->redirect_uri	= $afurl->full;
$oauth->session_started	= true;




if ($ok = $oauth->Initialize()) {
	if (stripos($get->server('HTTP_REFERER'), $afurl->host) === 0) {
		$_SESSION['referer'] = $get->server('HTTP_REFERER');
	}

	if ($get->int('add')) $_SESSION['auth_add'] = 1;

	if ($ok = $oauth->Process()) {
		if ($ok = strlen($oauth->access_token)) {
			$ok = $oauth->CallAPI(
				'https://api.twitter.com/1.1/account/verify_credentials.json',
				'GET', array(), array('FailOnAccessError'=>true), $userdata);
		}
	}
	if ($ok) {
		$ok = $oauth->Finalize($ok);
	}
}

if($oauth->exit) exit;


//CLEAR SESSION, JUST IN CASE IT CONTAINS STALE INFORMATION!
unset($_SESSION['OAUTH_STATE']);
unset($_SESSION['OAUTH_ACCESS_TOKEN']);

//ADD TO EXISTING AUTH?
$authadd = !!$get->session('auth_add')  &&  !!$user['user_id'];
unset($_SESSION['auth_add']);


//ERRORS N SHTUFFZ, SO EXIT, Y0
if(!$ok  ||  empty($userdata)) {
	$afurl->redirect($afurl->host . $afurl->base);
}



//ALL IS GOOD, LET'S START TRANSACTIONS!
$db->begin();



//CLEAR OUT ANY POTENTIAL EXISTING SESSION
if (!$authadd) {
	$af->logout(false, false);
} else {
	$authadd = $user;
}

//SANITIZE USER ID INPUT
$user_id = preg_replace('/[^0-9]/', '', $userdata->id_str);

//CHECK FOR EXISTING USER PROFILE//
$user = $db->row([
	'us'=>'pudl_user',
	'tw'=>'pudl_user_twitter'
], [
	'tw.tw_user_id' => $user_id,
	'us.user_id=tw.pudl_user_id'
]);


//USER ALREADY EXISTS, JUST UPDATE SESSION
if (!empty($user)) {
	$user = new afUser($db, $user);

	switch($user['user_permission']) {
		case 'banned':
		case 'guest':
		case 'pending':
			return;
	}

	//UPDATE SESSION DATA
	$af->authenticate($user);

	$db->updateId('pudl_user_twitter', [
		'tw_auth_token'  => $oauth->access_token,
		'tw_auth_secret' => $oauth->access_token_secret,
	], 'pudl_user_id', $user['user_id']);



//USER DOESN'T EXIST, IMPORT THEIR INFORMATION
} else {
	$insert_tw = [];
	$insert_cp = [];
	$insert_co = [];

	$insert_tw['tw_auth_token']		= $oauth->access_token;
	$insert_tw['tw_auth_secret']	= $oauth->access_token_secret;
	$insert_tw['tw_user_id']		= $user_id;

	$insert_cp['user_name']			= $userdata->screen_name;
	$insert_tw['tw_username']		= $userdata->screen_name;

	if (!empty($userdata->lang))		$insert_tw['tw_language']	= $userdata->lang;
	if (!empty($userdata->name))		$insert_tw['tw_full_name']	= $userdata->name;
	if (!empty($userdata->verified))	$insert_tw['tw_verified']	= (int)$userdata->verified;
	if (!empty($userdata->created_at))	$insert_tw['tw_created']	= strtotime($userdata->created_at);

	if (!empty($userdata->utc_offset))	{
		//$insert_cp['user_timezone']	= $userdata->utc_offset / 3600;
		$insert_tw['tw_timezone']	= $userdata->utc_offset;
	}


	if (!empty($userdata->location)) {
		//$insert_cp['user_location'] = $geo->clean($userdata->location);
		$insert_tw['tw_location']	= $userdata->location;
	}


	//INSERT NEW USER DATA
	if (empty($authadd)) {
		$insert_tw['pudl_user_id'] = $db->insert('pudl_user', $insert_cp);

		//INSERT USER PROFILE
		$insert_co['user_id'] = $insert_tw['pudl_user_id'];
		$db->insert('pudl_user_profile', $insert_co);

		// TODO: IMPORT TWITTER PROFILE IMAGE

		require('newuser.php.inc');

	} else {
		// WE ALREADY HAVE AN ACCOUNT, JUST LINK THEM TOGETHER!
		$insert_tw['pudl_user_id'] = $authadd['user_id'];
	}

	$db->insert('pudl_user_twitter', $insert_tw, true);

	$user = new afUser($db, $insert_tw['pudl_user_id']);
	$af->authenticate($user);
}



//Time to finish up that transaction!
$db->commit();


require('redirect.php.inc');
