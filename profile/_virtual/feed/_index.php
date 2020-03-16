<?php
require_once('feed/parse.php.inc');

$af->title = 'Feed';


require_once('../profile.php.inc');




////////////////////////////////////////////////////////////
//LOAD ALL THE FEED CONTENTS!!
////////////////////////////////////////////////////////////
$feed = $db->selectRows(
	[
		'ac.*',
		'us.*',
		'th.thumb_hash',
		'style' => pudl::text('profile'),
	],
	[
		'ac' => 'pudl_activity',
		'us' => _pudl_user(50),
	],
	['ac.user_id'=>$profile['user_id'], 'ac.user_id=us.user_id'],
	['activity_timestamp'=>pudl::dsc()],
	25
);




////////////////////////////////////////////////////////////
//PROCESS ALL THE THINGS!!
////////////////////////////////////////////////////////////
$render['feed'] = [];
foreach ($feed as &$item) {
	$item = array_merge($profile->raw(), $item);
	if (parse_feed($item)) $render['feed'][] = &$item;
} unset($item);




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////
$afurl->jq = 'feed/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq);
		$af->field('user', $profile);
		$af->merge($render);
	$af->render();
} else {
	require('_index.php');
}
