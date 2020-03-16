<?php

if (!empty($profile)) return;


////////////////////////////////////////////////////////////////////////////////
//BUILD PROFILE DATA
////////////////////////////////////////////////////////////////////////////////
$profile = [
	'type'		=> 'tag',
	'id'		=> $group['group_label_id'],
	'url'		=> "tag/$group[group_type_name]/" . $afurl->clean($group['group_label']),
	'name'		=> $group['group_label'],
	'img'		=> $afurl->cdn($group['thumb_hash']),
	'sub'		=> '',
	'follow'	=> 0,
	'imgdefault'=> "$group[group_type_name].svg",
	'cover'		=> $afurl->cdn($group['file_hash']),

	'edit'		=> $user->isStaff(),
];


if (empty($profile['img'])) {
	$profile['img'] = $afurl->static . '/thumb2/' . $group['group_type_name'] . '.svg';
}




////////////////////////////////////////////////////////////////////////////////
//BUILD COVER PHOTO DATA
////////////////////////////////////////////////////////////////////////////////
$actions = [];
