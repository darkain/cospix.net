<?php


$size = $af->prometheus() ? 500 : 200;




////////////////////////////////////////////////////////////
//LINKIFY USER PROFILE
////////////////////////////////////////////////////////////
$render['account'] = &$profile;
$profile['bio'] = afString::linkify($profile['user_bio']);




////////////////////////////////////////////////////////////
//ASK BOX
////////////////////////////////////////////////////////////
$render['ask'] = $db->selectRows(
	'*',
	['ak'=>'pudl_ask', 'us'=>_pudl_user(50)],
	[
		'receiver_id' => $profile['user_id'],
		'ak.sender_id=us.user_id',
		cpnFilterBanned(),
		$user->is($profile) ? true : 'answer_time!=0',
	],
	['answer_time'=>pudl::neq(0), 'question_time'=>pudl::dsc()],
	5
);

$afurl->cdnAll($render['ask'], 'img', 'thumb_hash');




////////////////////////////////////////////////////////////
//PULL YOUTUBE DATA
////////////////////////////////////////////////////////////
$render['youtube'] = $db->rowId('pudl_youtube', 'youtube_id', $profile->youtube_id);

if (!empty($render['youtube'])) {
	$render['youtube']['text'] = afString::linkify(
		$render['youtube']['youtube_description']
	);
}




////////////////////////////////////////////////////////////
//PULL ATTENDING EVENTS DATA
////////////////////////////////////////////////////////////
$time = $db->time();

$result = $db->group(
	['ev.*', 'th.thumb_hash'],
	['ue'=>'pudl_user_event', 'ev'=>_pudl_event(50)],
	['ev.event_id=ue.event_id',	'ue.user_id'=>$profile['user_id']],
	'ev.event_id',
	['event_start'=>pudl::dsc()]
);

$render['eventlist'] = $result->rows();
$result->free();

$afurl->cdnAll($render['eventlist'], 'img', 'thumb_hash');

foreach ($render['eventlist'] as &$item) {
	$item['range'] = \af\time::daterange($item['event_start'], $item['event_end']);

	if ($item['event_start'] > $db->time()) {
		$days = round(($item['event_start'] - $db->time()) / AF_DAY);
		if ($days < 2) {
			$item['countdown'] = 'NOW!';
		} else {
			$item['countdown'] = $days . ' days';
		}
	}
} unset($item);




////////////////////////////////////////////////////////////
// OPEN GRAPH, TWITTER CARD, MICRO DATA
////////////////////////////////////////////////////////////
$og['description'] = substr($profile['user_bio'] || '', 0, 300);

$thumb = $db->selectRow(
	'thumb_hash',
	['us' => _pudl_user(200)],
	['us.user_id' => $router->id]
);

$og['image'] = $afurl->cdn($thumb, 'thumb_hash');

$af->metas([
	['name'=>'twitter:card',		'content'=>'summary'],
	['name'=>'twitter:site',		'content'=>'@cospixnet'],
	['name'=>'twitter:domain',		'content'=>'Cospix.net'],
	['name'=>'twitter:title',		'content'=>$profile['user_name'] . ' - ' . $og['title']],
	['name'=>'twitter:image',		'content'=>$og['image']],
	['name'=>'twitter:description',	'content'=>$og['description']],
]);




////////////////////////////////////////////////////////////
//BADGES
////////////////////////////////////////////////////////////
$render['badge'] = $db->rows(
	['bg'=>'pudl_badge', 'ub'=>'pudl_user_badge'],
	[
		'bg.badge_id=ub.badge_id',
		'ub.user_id' => $profile['user_id'],
	],
	['badge_timestamp'=>pudl::dsc()]
);





////////////////////////////////////////////////////////////
//RECENT UPDATES
////////////////////////////////////////////////////////////
$render['g'] = $db->selectRows(
	'*',
	[
		'ga' => _pudl_gallery($size),
		'fl' => 'pudl_file',
		'us' => 'pudl_user',
	],
	[
		'us.user_id' => $profile['user_id'],
		'th.file_hash=fl.file_hash',
		'ga.user_id=us.user_id',
	],
	['gallery_timestamp'=>pudl::dsc()],
	12
);

$afurl->cdnAll($render['g'], 'img', 'thumb_hash');




////////////////////////////////////////////////////////////
//USER PROFILE TYPES
////////////////////////////////////////////////////////////
$profile['user_type'] = array_flip(explode(',', $profile['user_type']));

//OLD CODE
$render['types'] = [];
foreach ($profile['user_type'] as $key => $type) {
	if (!empty($afusertypes[$key])) {
		$render['types'][] = ['key'=>$key, 'val'=>$afusertypes[$key]];
	}
}

//PROMETHEUS CODE
$render['things'] = [];
foreach ($profile['user_type'] as $key => $type) {
	if (empty($key)) continue;

	$parts = explode('-', $key);
	if (count($parts) === 1) $parts = ['other', $parts[0]];

	$label		= explode('-', $afusertypes[$key]);
	$parts[1]	= trim(end($label));

	if (count($label) > 1) $parts[0] = reset($label);

	$render['things'][] = $parts;
}

array_multisort($render['things']);
