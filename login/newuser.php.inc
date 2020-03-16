<?php

if (empty($account)) {
	$account = new afUser($db, $insert_co);
}



//SET INITIAL USER PREFERENCES
$account->setPreferences([
	'facebook_post_attending'	=> true,
	'facebook_post_gallery'		=> true,
	'twitter_post_attending'	=> true,
	'cospix_commentprofile'		=> true,
	'cospix_commentgallery'		=> true,
	'cospix_commentarticle'		=> true,
	'cospix_commentphoto'		=> true,
	'cospix_commentfeed'		=> true,
	'cospix_commentreply'		=> true,
	'cospix_follow'				=> true,
	'cospix_questionask'		=> true,
	'cospix_questionanswer'		=> true,
	'email_commentprofile'		=> true,
	'email_commentgallery'		=> true,
	'email_commentarticle'		=> true,
	'email_commentphoto'		=> true,
	'email_commentfeed'			=> true,
	'email_commentreply'		=> true,
	'email_follow'				=> true,
	'email_questionask'			=> true,
	'email_questionanswer'		=> true,
]);



//GIVE THE USER A REGISTRATION BADGE
//BADGE DOUBLES AS REGISTRATION TIMESTAMP
$db->insert('pudl_user_badge', [
	'user_id'			=> $account->user_id,
	'badge_id'			=> 20,
	'badge_timestamp'	=> $db->time(),
]);



//SET THE USER TO FOLLOW THEMSELVES
$db->insert('pudl_follow', [
	'user_id'			=> $account->user_id,
	'follow_id'			=> $account->user_id,
	'follow_timestamp'	=> $db->time(),
]);
