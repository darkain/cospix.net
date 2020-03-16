<?php


if ($user->loggedIn()) {
	require('redirect.php.inc');
}


require_once('_oauth/http.php');
require_once('_oauth/oauth_client.php');

$oauth = new oauth_client_class;
$oauth->server			= 'Google';
$oauth->client_id		= $afconfig->google['client_id'];
$oauth->client_secret	= $afconfig->google['secret'];
$oauth->redirect_uri	= $afurl->full;
$oauth->session_started	= true;

$oauth->scope			= 'https://www.googleapis.com/auth/userinfo.email ' .
						  'https://www.googleapis.com/auth/userinfo.profile';

if ($ok = $oauth->Initialize()) {
	if (stripos($get->server('HTTP_REFERER'), $afurl->host) === 0) {
		$_SESSION['referer'] = $get->server('HTTP_REFERER');
	}

	if ($get->int('add')) $_SESSION['auth_add'] = 1;

	if ($ok = $oauth->Process()) {
		if ($ok = strlen($oauth->access_token)) {
			$ok = $oauth->CallAPI(
				'https://www.googleapis.com/oauth2/v1/userinfo',
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
$user_id = preg_replace('/[^0-9]/', '', $userdata->id);

//CHECK FOR EXISTING USER PROFILE//
$user = $db->row(
	['us'=>'pudl_user', 'go'=>'pudl_user_google'],
	['go.go_user_id'=>$user_id, 'us.user_id=go.pudl_user_id']
);



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

	$db->updateId('pudl_user_google', [
		'go_auth_token'		=> $oauth->access_token,
		'go_auth_secret'	=> $oauth->access_token_secret,
	], 'pudl_user_id', $user['user_id']);



//USER DOESN'T EXIST, IMPORT THEIR INFORMATION
} else {
	$insert_go = [];
	$insert_cp = [];
	$insert_co = [];

	$insert_go['go_auth_token']		= $oauth->access_token;
	$insert_go['go_auth_secret']	= $oauth->access_token_secret;
	$insert_go['go_user_id']		= $user_id;

	$insert_cp['user_name']			= $user_id;

	if (!empty($userdata->given_name))		$insert_go['go_full_name']	= $userdata->given_name;
	if (!empty($userdata->verified_email))	$insert_go['go_verified']	= (int)$userdata->verified_email;
	if (!empty($userdata->locale))			$insert_go['go_locale']		= $userdata->locale;

	if (!empty($userdata->email)) {
		$insert_co['user_email']	= $userdata->email;
		$insert_go['go_email']		= $userdata->email;
	}


	//INSERT NEW USER DATA
	if (empty($authadd)) {
		$insert_go['pudl_user_id'] = $db->insert('pudl_user', $insert_cp, true);

		//INSERT USER PROFILE
		$insert_co['user_id'] = $insert_go['pudl_user_id'];
		$db->insert('pudl_user_profile', $insert_co);

		// TODO: IMPORT GOOGLE PROFILE IMAGE

		require('newuser.php.inc');

	} else {
		// WE ALREADY HAVE AN ACCOUNT, JUST LINK THEM TOGETHER!
		$insert_go['pudl_user_id'] = $authadd['user_id'];
	}

	$db->insert('pudl_user_google', $insert_go, true);

	$user = new afUser($db, $insert_go['pudl_user_id']);
	$af->authenticate($user);
}



//Time to finish up that transaction!
$db->commit();



require('redirect.php.inc');
