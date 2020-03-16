<?php

/*
if no page, start at beginning
if jq, then send only single requested page
if not jq, send all pages up to the requested page
*/

//TODO: CONVERT DISCOVER OVER TO NEW PROMETHEUS ORM RENDERER


//TODO: !! OPEN GRAPH PER ITEM / META DATA PER ITEM (LIKE EVENTS IN GOOGLE SEARCH RESULTS)


$af->title	= 'Discover Cosplay';
$page		= max($get->int('page'), 0);

if ($page === 0) {
	$af	->header()
			->load('_index.tpl')
				->field('page', 0)
				->block('item', [])
			->render()
		->footer();
	return;
}




$size		= 24;
$thumb		= 200;

if ($af->prometheus()) {
	$thumb	= 500;
}




$minrank	= 0;
$today		= floor($db->time() / AF_DAY);
$data		= [];	//OUTPUT DATA
$tags		= [];	//LISTING OF TAG IDS TO IGNORE
$events		= [];	//LISTING OF EVENT IDS TO IGNORE
$galleries	= [];	//LISTING OF GALLERY IDS TO IGNORE

//LISTING OF IMAGE HASHES TO IGNORE
$images = $db->cache(AF_MINUTE*5)->collection('pudl_undiscover');



//require('daily-photos.php.inc');

//	must come first due to caching layer
require('random.php.inc');

require('recent-galleries.php.inc');
require('trending-series.php.inc');
require('trending-images.php.inc');


//require('recent-events.php.inc');

if ($user->loggedIn()) {
	$profile = $db->rowId('pudl_user_profile', 'user_id', $user);
	if (!empty($profile['user_lat'])  ||  !empty($profile['user_lon'])) {
//		require('event-distance.php.inc');
	}
}



ksort($data, SORT_NUMERIC);
if ($get->int('jq')) {
	$data = array_slice($data, ($page-1)*$size, $size);
} else {
	$data = array_slice($data, 0, $page*$size);
}
\af\affirm(404, $data);



if ($get->int('jq')) {
	$af	->load($af->config->root.'/discover.tpl')
			->block('item',			$data)
		->render();
} else {
	$af	->header()
			->load('_index.tpl')
				->field('page',		$page)
				->block('item',		$data)
			->render()
		->footer();
}
