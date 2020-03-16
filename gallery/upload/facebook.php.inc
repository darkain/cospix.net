<?php

////////////////////////////////////////////////////////////
//PULL FACEBOOK INFO
////////////////////////////////////////////////////////////
$fbuser = $db->rowId('pudl_user_facebook', 'pudl_user_id', $user['user_id']);

if (empty($fbuser)  ||  !$user->getPreference('facebook_post_gallery')) return;




////////////////////////////////////////////////////////////
//GENERATE FACEBOOK POST ATTACHMENT
////////////////////////////////////////////////////////////
$link = "$afurl->host$afurl->base/$user[user_url]/$gallery[gallery_type]/$gallery[gallery_id]";
$attachment = array(
	'message' => "I updated my $gallery[gallery_type] $gallery[gallery_name] - $link",
	'link' => $link,
	'description' => "$gallery[gallery_name] $gallery[gallery_type] by $user[user_name]",
	'name' => $gallery['gallery_name'],
);

if (!empty($gallery['img'])) {
	$attachment['picture'] = $gallery['img'];
}




////////////////////////////////////////////////////////////
//QUE UP POST IN CRON SYSTEM
////////////////////////////////////////////////////////////
$user->queue('facebook', "gallery.update.$gallery[gallery_id]", $attachment);
