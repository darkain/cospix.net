<?php

$af->title = 'Feed';
$og['description'] = 'Feed - ';

require_once('../event.php.inc');
require_once('feed/parse.php.inc');




$af->script($afurl->static . '/js/underscore.js');
$af->script($afurl->static . '/js/jquery-textntags.js');
$af->style( $afurl->static . '/css/jquery-textntags.css');




$render['feed'] = $db->group([
		'fw.*',
		'ac.*',
		'us.*',
		'th.thumb_hash',
		'style'			=> pudl::text('event'),
		'user_count'	=> pudl::count(),
	], [
		'fw' => 'pudl_follow',
		'ac' => 'pudl_activity',
		'us' => _pudl_user(50),
	], [
		'fw.user_id' => $user['user_id'],
		'ac.user_id=fw.follow_id',
		'ac.user_id=us.user_id',
		cpnFilterBanned(),
	], [
		'ac.object_id',
		'ac.object_type_id',
		'ac.file_hash',
		'us.user_id',
	], [
		'activity_timestamp' => pudl::dsc(),
	],
	25
)->complete();



foreach ($render['feed'] as $key => &$item) {
	$item['user_count']--;
	if (empty($item['user_count'])) $item['user_count'] = '';

	if (!parse_feed($item)) unset($render['feed'][$key]);
} unset($item);




/////////////////////////////////////////////
// RENDER ALL THE THINGS
/////////////////////////////////////////////
$afurl->jq = 'feed/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq);
		$af->field('event', $event);
		$af->merge($render);
	$af->render();
} else {
	require('_index.php');
}
