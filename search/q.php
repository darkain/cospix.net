<?php

//TODO: this is still shoving users to /profile/1/ instead of /darkain/

$term = $get->search('term');



////////////////////////////////////////////////////////////////////////////////
//COMPLEX CLAUSE
////////////////////////////////////////////////////////////////////////////////
$clause	= [];
$parts	= explode(' ', $term);
foreach ($parts as $part) {
	$clause[0][] = ['event_name' => pudl::like($part)];
}




////////////////////////////////////////////////////////////////////////////////
//UNIONS!
////////////////////////////////////////////////////////////////////////////////
$db->unionStart();




////////////////////////////////////////////////////////////////////////////////
//SEARCH EVENTS
////////////////////////////////////////////////////////////////////////////////
$db->group(
	[
		'id' 		=> 'ev.event_id',
		'value'		=> 'event_name',
		'url'		=> pudl::text('event'),
		'img'		=> 'thumb_hash',
		'path'		=> NULL,
	], [
		'ev' => _pudl_event(50)+[[
			'left'		=> ['ue'=>'pudl_user_event'],
			'clause'	=> [
				'ev.event_id=ue.event_id',
				'ue.user_id' => $user['user_id']
			]
		]]
	], [
		pudl::notFind('event_details', 'canceled'),
		$clause + [
			'event_venue'		=> pudl::like($term),
			'event_location'	=> pudl::like($term),
			'event_website'		=> pudl::like($term),
			'event_twitter'		=> pudl::like($term),
		],
	],
	'ev.event_id',
	[
		'user_id'				=> pudl::dsc(),
		'event_start'			=> pudl::dsc(),
		'event_name',
	],
	10
);




////////////////////////////////////////////////////////////////////////////////
//SEARCH USERS
////////////////////////////////////////////////////////////////////////////////
$db->group(
	[
		'id'		=> 'us.user_id',
		'value'		=> 'user_name',
		'url'		=> pudl::text('profile'),
		'img'		=> 'thumb_hash',
		'path'		=> 'user_url',
	],
	[
		'us' => _pudl_user(50),
		'uo' => 'pudl_user_profile',
	],
	[
		cpnFilterBanned(),
		'us.user_id=uo.user_id',
		[
			'user_name'		=> pudl::like($term),
			'user_url'		=> afString::ascii($term) ? pudl::like($term) : 0,
			'user_location'	=> pudl::like($term),
		],
	],
	'us.user_id',
	false,
	10
);




////////////////////////////////////////////////////////////////////////////////
//SEARCH TAGS / LABELS
////////////////////////////////////////////////////////////////////////////////
$db->group([
	'id'		=> 'group_label_id',
	'value'		=> 'group_label',
	'url'		=> pudl::text('tag'),
	'img'		=> 'thumb_hash',
	'path'		=> 'group_type_name'
], [
	'gl' => 'pudl_group_label',
	'gr' => _pudl_group(50),
	'gt' => 'pudl_group_type',
], [
	'gl.group_label' => pudl::like( afString::slash($term) ),
	'gr.group_id=gl.group_id',
	'gt.group_type_id=gr.group_type_id',
], [
	'gl.group_label',
	'gt.group_type_id'
], [
	'gt.group_type_id',
	'gl.group_label'	=> pudl::neq( afString::slash($term) ),
	'gr.group_icon'		=> NULL,
	'gt.group_type_id',
], 10);




////////////////////////////////////////////////////////////////////////////////
//UNIONS!!
////////////////////////////////////////////////////////////////////////////////
$result	= $db->unionEnd(false, 20);




////////////////////////////////////////////////////////////////////////////////
//PROCESS ALL THE DATAS N STUFFS
////////////////////////////////////////////////////////////////////////////////
$rows = [];
while ($val = $result()) {
	if (!empty($val['img'])) {
		$val['img'] = $afurl->cdn($val['img']);
	} else if ($val['url'] === 'tag') {
		$val['img'] = $afurl->static . '/thumb2/' . $val['path'] . '.svg';
	} else if ($val['url'] === 'event') {
		$val['img'] = $afurl->static . '/thumb2/convention.svg';
	} else if ($val['url'] === 'profile') {
		$val['img'] = $afurl->static . '/thumb2/profile.svg';
	} else {
		$val['img'] = $afurl->static . '/thumb2/tag.svg';
	}

	switch ($val['url']) {
		case 'event':
			$val['id'] = $afurl->clean($val['value']);
		break;

		case 'tag':
			$val['id'] = $val['path'] . '/' . $afurl->clean($val['value']);
		break;
	}

	if (strlen($val['value']) > 40) {
		$val['value'] = substr($val['value'], 0, 40) . '...';
	}

	$rows[] = $val;
} unset($val);

$result->free();




////////////////////////////////////////////////////////////////////////////////
//OUTPUT ALL THE THINGS!!
////////////////////////////////////////////////////////////////////////////////
$af->json($rows);
