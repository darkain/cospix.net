<?php

require_once('parse.php.inc');

$user->requireLogin();

$af->script($afurl->static . '/js/underscore.js');
$af->script($afurl->static . '/js/jquery-textntags.js');
$af->style( $afurl->static . '/css/jquery-textntags.css');


$af->title = 'Activity Feed';


$offset = $get->int('from');
$clause = empty($offset) ? [] : ['activity_timestamp'=>pudl::lt($offset)];

$result = $db->group([
		'fw.*',
		'ac.*',
		'us.*',
		'th.thumb_hash',
		'style'			=> pudl::text('feed'),
		'user_count'	=> pudl::count(),
	], [
		'fw' => 'pudl_follow',
		'ac' => 'pudl_activity',
		'us' => _pudl_user(50),
	], $clause+[
		'fw.user_id' => $user['user_id'],
		'ac.user_id=fw.follow_id',
		'ac.user_id=us.user_id',
		cpnFilterBanned(),
	], [
		'ac.object_id',
		'ac.object_type_id',
		'ac.file_hash',
		'us.user_id',
	],
	[
		'activity_timestamp'=>pudl::dsc()
	],
	25
);

$render['feed'] = $result->rows();
$result->free();


foreach ($render['feed'] as $key => &$item) {
	$item['user_count']--;
	if (empty($item['user_count'])) $item['user_count'] = '';

	if (!parse_feed($item)) unset($render['feed'][$key]);
} unset($item);


if (empty($offset)) {
	$af->header();
		$af->load('_index.tpl');
			$af->block('feed', $render['feed']);
		$af->render();
	$af->footer();
} else {
	$af->renderBlock('feed.tpl', 'feed', $render['feed']);
}
