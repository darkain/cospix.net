<?php
$user->requireStaff();

$af->title = 'Admin';


require_once('../profile.php.inc');




////////////////////////////////////////////////////////////
//LOAD ALL THE CONTENTS!!
////////////////////////////////////////////////////////////
//TODO:	WHICH ALL THESE PUDL_USER_ID OVER TO USER_ID
//		ONCE DONE, ALL THE NEW PUDL SHORTCUTS WILL WORK!
$render['facebook']	= $db->rowId('pudl_user_facebook',	'pudl_user_id', $profile['user_id']);
$render['twitter']	= $db->rowId('pudl_user_twitter',	'pudl_user_id', $profile['user_id']);
$render['google']	= $db->rowId('pudl_user_google',	'pudl_user_id', $profile['user_id']);

$render['auth']		= $db->rowId('pudl_user_auth',		$profile);
$render['access']	= $db->rowId('pudl_user_access',	$profile);
$render['account']	= &$profile;




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////
$afurl->jq = 'admin/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq);
		$af->field('user', $profile);
		$af->merge($render);
	$af->render();
} else {
	require('_index.php');
}
