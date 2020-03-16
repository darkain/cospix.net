<?php

require_once('parse.php.inc');

$user->requireLogin();



/////////////////////////////////////////////
// Open Graph data
/////////////////////////////////////////////
$og['description'] = 'Cospix.net is the premiere
social networking website connecting cosplayers,
photographers and many more from the cosplay
community. Users can make galleries, organize
costumes, write articles, and find the latest
conventions near them. Sign-up is free!';



//$af->title = 'Activity Feed';

/////////////////////////////////////////////
// FEED ITEMS
/////////////////////////////////////////////
$offset = $get->int('from');
$clause = empty($offset) ? [] : ['activity_timestamp'=>pudl::lt($offset)];

$result = $db->group(
	['*', 'user_count' => pudl::count()],
	[
		'fw' => 'pudl_follow',
		'ac' => 'pudl_activity',
		'us' => _pudl_user(200),
	],
	array_merge($clause, [
		'fw.user_id' => $user['user_id'],
		'ac.user_id=fw.follow_id',
		'ac.user_id=us.user_id',
		cpnFilterBanned(),
	]),
	['object_id', 'object_type_id'],
	['activity_timestamp'=>pudl::dsc()],
	25
);

$render['feed'] = $result->rows();
$result->free();


foreach ($render['feed'] as $key => &$item) {
	$item['user_count']--;
	if (empty($item['user_count'])) $item['user_count'] = '';

	if (!parse_feed($item)) unset($render['feed'][$key]);
} unset($item);




/////////////////////////////////////////////
// UPCOMING EVENTS
/////////////////////////////////////////////
if (empty($offset)) {
	$evtime = $db->time() - AF_DAY;
	$events = $db->selectRows(
		'*',
		array('ev' => _pudl_event(50)),
		"event_end>$evtime",
		'event_start',
		20
	);

	$afurl->cdnAll($events, 'img', 'thumb_hash');
}




/////////////////////////////////////////////
// RECENTLY UPDATED GALLERIES / COSTUMES
/////////////////////////////////////////////
if (empty($offset)) {
	$result = $db->group(
		[
			'us.*',
			'ga.*',
			'th.*',
		],
		[
			'ga' => _pudl_gallery(50),
			'us' => 'pudl_user',
			'gi' => 'pudl_gallery_image',
		],
		[
			'us.user_id=ga.user_id',
			'gi.gallery_id=ga.gallery_id',
			'ga.gallery_thumb'		=> pudl::neq(NULL),
			['ga.gallery_name'		=> pudl::neq(NULL)],
			['ga.gallery_name'		=> pudl::neq('')],
			cpnFilterBanned(),
		],
		'ga.gallery_id',
		[
			'ga.gallery_timestamp'	=> pudl::dsc(),
			'ga.gallery_id'			=> pudl::dsc()
		],
		20
	);

	$costumes = $result->rows();
	$result->free();

	$afurl->cdnAll($costumes, 'img', 'thumb_hash');
}




/////////////////////////////////////////////
// RENDER EVERYTHING
/////////////////////////////////////////////
if (empty($offset)) {
	$af->header();
		$af->load('new.tpl');
			$af->block('feed',		$render['feed']);
			$af->block('g',			$costumes);
			$af->block('eventlist', $events);
		$af->render();
	$af->footer();
} else {
	$af->renderBlock('feed.tpl', 'feed', $render['feed']);
}
