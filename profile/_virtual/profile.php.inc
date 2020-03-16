<?php

////////////////////////////////////////////////////////////////////////////////
//PULL PROFILE DATA BY USER ID
////////////////////////////////////////////////////////////////////////////////
if (ctype_digit($router->virtual[0])) {
	$profile = $db->row(
		['us'=>_pudl_user(200)+[['natural'=>'pudl_user_profile']]],
		['us.user_id'=>$router->virtual[0], cpnFilterBanned()]
	);
	\af\affirm(404, $profile);

	if (!empty($profile['user_url'])) {
		$path  = $afurl->base;
		$path .= preg_replace("~/$profile[user_id]~", "/$profile[user_url]", $afurl->url);
		$path  = str_replace('/profile/', '/', $path);
		$afurl->redirect(rtrim($path, '/'));
	}

	$profile['user_url'] = $profile['user_id'];




////////////////////////////////////////////////////////////////////////////////
//PULL PROFILE DATA BY USER CUSTOM URL
////////////////////////////////////////////////////////////////////////////////
} else if (ctype_alnum($router->virtual[0])) {
	$profile = $db->row(
		['us'=>_pudl_user(200)+[['natural'=>'pudl_user_profile']]],
		['us.user_url'=>$router->virtual[0], cpnFilterBanned()]
	);
	\af\affirm(404, $profile);




////////////////////////////////////////////////////////////////////////////////
//BAD REQUEST BRUH!
////////////////////////////////////////////////////////////////////////////////
} else {
	\af\error(404);
}




////////////////////////////////////////////////////////////////////////////////
//CONVERT TO OBJECT
////////////////////////////////////////////////////////////////////////////////
$profile = new afUser($db, $profile);
$profile['url'] = $profile->url();




////////////////////////////////////////////////////////////////////////////////
//PULL IMAGE FOR PROFILE COVER PHOTO
////////////////////////////////////////////////////////////////////////////////
$cover = !empty($profile->user_cover)
		 ? $profile->user_cover
		 : $profile->file_hash;

if (!empty($cover)) {
	$file = $db->row([
		'fl' => 'pudl_file',
		'th' => 'pudl_file_thumb',
	], [
		'fl.file_hash=th.file_hash',
		'fl.file_hash'	=> $cover,
		'thumb_type'	=> '800',
	]);

	$profile->cover = $afurl->cdn($file, 'thumb_hash', 'mime_id');
}




////////////////////////////////////////////////////////////////////////////////
//REBASE CURRENT WORKING DIRECTORY
////////////////////////////////////////////////////////////////////////////////
if (count($router->virtual) > 1) {
	$profile['page_id'] = array_pop($router->virtual);
	if (!ctype_digit($profile['page_id'])) $profile['page_id'] = 0;
	chdir('../');
	$profile['subpage'] = 1;
}




////////////////////////////////////////////////////////////////////////////////
//BUILD PROFILE DATA
////////////////////////////////////////////////////////////////////////////////
$render = ['profile' => [
	'type'			=> 'profile',
	'id'			=> $profile['user_id'],
	'url'			=> $afurl->clean($profile['user_url']),
	'name'			=> $profile['user_name'],
	'img'			=> $profile->image(),
	'sub'			=> $profile['user_tagline'],
	'edit'			=> $user->is($profile),
	'imgdefault'	=> 'profile.svg',
	'cover'			=> $profile->cover,
]];



if ($user->loggedIn()  &&  !$user->is($profile)) {
	if ($db->clauseExists('pudl_follow', [
		'user_id'	=> $user['user_id'],
		'follow_id'	=> $profile['user_id'],
	  ])) {
		$render['profile']['button'] = '- Unfollow';
	} else {
		$render['profile']['button'] = '+ Follow';
	}
}


if ($user->is($profile)  &&  strpos($profile['user_attributes'], 'verifyemail')!==false) {
	$af->headers('notice', [
		'text' => 'Please verify your email address by clicking on the link '
				. 'within the email.'
	]);
}




////////////////////////////////////////////////////////////////////////////////
//BUILD COVER PHOTO DATA
////////////////////////////////////////////////////////////////////////////////
$actions = [
	'Followers'		=> [
		'count'		=> $db->countId('pudl_follow', 'follow_id', $profile->id()),
		'link'		=> 'followers',
	],

	'Badges'		=> [
		'count'		=> $db->countId('pudl_user_badge', $profile),
	],

	'Galleries'		=> [
		'count'		=> $db->countId('pudl_gallery', $profile),
		'link'		=> 'galleries'
	],

	'Events'		=> [
		'count'		=> $db->countId('pudl_user_event', $profile),
		'link'		=> 'conventions'
	],
];
