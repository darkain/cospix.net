<?php


$template		= 'profile/list.tpl';
$block			= 'users';
$size			= 100;

if ($af->prometheus()) {
	$template	= 'discover/_index.tpl';
	$block		= 'item';
	$size		= 500;
}

if (empty($clause))	$clause	= [];
if (empty($order))	$order	= [];
if (empty($limit))	$limit	= false;




////////////////////////////////////////////////////////////////////////////////
//PULL THE USERS FROM THE DATABASE
//TODO: CONVERT THIS OVER TO PROMETHEUS
////////////////////////////////////////////////////////////////////////////////
$users = $db->group([
	'us.*',
	'uo.*',
	'th.file_hash',
	'th.thumb_hash',
	'fl.file_width',
	'fl.file_height',
	'fl.file_average',
	'fl.mime_id',
], [
	'uo' => 'pudl_user_profile',
	'ga' => 'pudl_gallery',
	'fl' => 'pudl_file',
	'us' => _pudl_user($size),
], $clause+[
	-1 => 'us.user_id=uo.user_id',
	-2 => 'us.user_id=ga.user_id',
	-3 => 'th.file_hash=fl.file_hash',
	-4 => cpnFilterBanned(),
], [
	'us.user_id',
], $order+[
	'thumb_hash' => NULL,
	'us.user_name',
], $limit)->complete();




////////////////////////////////////////////////////////////////////////////////
//PROCESS THUMBNAILS
////////////////////////////////////////////////////////////////////////////////
$afurl->cdnAll($users, 'img', 'thumb_hash', 'mime_id');




////////////////////////////////////////////////////////////////////////////////
//CALCULATE WIDTH/HEIGHT RATIO
////////////////////////////////////////////////////////////////////////////////
foreach ($users as &$item) {
	$item['width']	= $af->discoverWidth($item);
	$item['name']	= $item['user_tagline'];

	$item['url']	= $afurl->user($item);
} unset($item);




////////////////////////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS
////////////////////////////////////////////////////////////////////////////////
$af	->header()
		->load($template)
			->field('profile', [])
			->block($block, $users)
		->render()
	->footer();
