<?php


if ($user->loggedIn()) {
	require('redirect.php.inc');
}


require_once('_oauth/http.php');
require_once('_oauth/oauth_client.php');


$oauth = new oauth_client_class;
$oauth->server			= 'Facebook';
$oauth->client_id		= $afconfig->facebook['id'];
$oauth->client_secret	= $afconfig->facebook['secret'];
$oauth->redirect_uri	= $afurl->full;
$oauth->session_started	= true;

//$oauth->scope			= 'publish_actions,email,manage_pages,publish_pages';
$oauth->scope			= 'email';


if ($ok = $oauth->Initialize()) {
	if (stripos($get->server('HTTP_REFERER'), $afurl->host) === 0) {
		$_SESSION['referer'] = $get->server('HTTP_REFERER');
	}

	if ($get->int('add')) $_SESSION['auth_add'] = 1;

	if ($ok = $oauth->Process()) {
		if ($ok = strlen($oauth->access_token)) {
			$ok = $oauth->CallAPI(
				'https://graph.facebook.com/v2.4/me',
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
	['us'=>'pudl_user', 'fb'=>'pudl_user_facebook'],
	['fb.fb_user_id'=>$user_id, 'us.user_id=fb.pudl_user_id']
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

	//UPDATE FACEBOOK PROVIDED EMAIL ADDRESS
	$update = ['fb_auth_token' => $oauth->access_token];
	if (isset($userdata->email)) $update['fb_email'] = $userdata->email;

	$db->updateId('pudl_user_facebook', $update, 'fb_user_id', $user_id);



//USER DOESN'T EXIST, IMPORT THEIR INFORMATION
} else {
	$insert_fb = array();
	$insert_cp = array();
	$insert_co = array();

	$insert_fb['fb_auth_token'] = $oauth->access_token;
	$insert_fb['fb_user_id']	= $user_id;

	if (!empty($userdata->timezone))		$insert_co['user_timezone']	= $userdata->timezone;
	if (!empty($userdata->locale))			$insert_co['user_locale']	= $userdata->locale;
	if (!empty($userdata->name))			$insert_fb['fb_full_name']	= $userdata->name;
	if (!empty($userdata->first_name))		$insert_fb['fb_first_name']	= $userdata->first_name;
	if (!empty($userdata->last_name))		$insert_fb['fb_last_name']	= $userdata->last_name;
	if (!empty($userdata->gender))			$insert_fb['fb_gender']		= $userdata->gender;
	if (!empty($userdata->verified))		$insert_fb['fb_verified']	= $userdata->verified;
	if (!empty($userdata->updated_time))	$insert_fb['fb_timestamp']	= @strtotime($userdata->updated_time);

	if (!empty($userdata->email)) {
		$insert_co['user_email']	= $userdata->email;
		$insert_fb['fb_email']		= $userdata->email;
	}

	if (!empty($userdata->username)) {
		$insert_cp['user_name']		= $userdata->username;
		$insert_fb['fb_username']	= $userdata->username;
	} else {
		$insert_cp['user_name']		= $user_id;
	}

	if (!empty($userdata->location->name)) {
		$insert_co['user_location']	= $geo->clean($userdata->location->name);
		$insert_fb['fb_location']	= $userdata->location->name;
	} else if (!empty($userdata->hometown->name)) {
		$insert_co['user_location']	= $geo->clean($userdata->hometown->name);
		$insert_fb['fb_location']	= $userdata->hometown->name;
	}

	if (!empty($userdata->link)) {
		$insert_fb['fb_url']		= $userdata->link;
	}


	//INSERT NEW USER DATA
	if (empty($authadd)) {
		$insert_fb['pudl_user_id']	= $db->insert('pudl_user', $insert_cp);

		//INSERT USER PROFILE
		$insert_co['user_id']		= $insert_fb['pudl_user_id'];
		$db->insert('pudl_user_profile', $insert_co);

		// IMPORT FACEBOOK PROFILE IMAGE
		if (!empty($userdata->link)) {
			$user = new afUser($db, $insert_cp);
			$user['user_id'] = $insert_co['user_id'];

			$import	= new \af\import($af, $db);
			$image	= $import->facebook($user_id);
			if (!empty($image['file_hash'])) {
				$db->updateId('pudl_user', [
					'user_icon' => $image['file_hash']
				], 'user_id', $insert_co);
			}
		}

		require('newuser.php.inc');

	} else {
		// WE ALREADY HAVE AN ACCOUNT, JUST LINK THEM TOGETHER!
		$insert_fb['pudl_user_id'] = $authadd['user_id'];
	}

	$db->insert('pudl_user_facebook', $insert_fb);

	$user = new afUser($db, $insert_fb['pudl_user_id']);
	$af->authenticate($user);
}



//Time to finish up that transaction!
$db->commit();



require('redirect.php.inc');
