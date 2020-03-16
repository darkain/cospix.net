<?php

$date	= $router->virtual[0];
$month	= (int) date('m', @strtotime($date));
$year	= (int) date('Y', @strtotime($date));

if ($year < 1971) {
	$month	= (int) date('m');
	$year	= (int) date('Y');
}

$start	= strtotime($year.'-'.($month+0).'-01');
$end	= strtotime($year.'-'.($month+1).'-01');
if ($month == 12) $end = strtotime(($year+1).'-01-01');


$af->title	= date('F Y', $start) . "\n Featured Photo Calendar";


////////////////////////////////////////////////////////////////////////////////
//RECENTLY FEATURED IMAGES
////////////////////////////////////////////////////////////////////////////////
$recent = $db->group([
	'fe.*',
	'us.*',
	'th.thumb_hash',
	'tx.mime_id',
	'ga.gallery_id',
	'name' => 'ga.gallery_name',
], [
	'fe' => 'pudl_feature',
	'gi' => _pudl_gallery_image(200),
	'ga' => 'pudl_gallery',
	'us' => 'pudl_user',
], [
	cpnFilterBanned(),
	'fe.file_hash=gi.file_hash',
	'fe.user_id=ga.user_id',
	'us.user_id=ga.user_id',
	'gi.gallery_id=ga.gallery_id',
	'fe.feature_timestamp' => pudl::between($start, $end),
], 'fe.file_hash', 'fe.feature_timestamp')->complete();

$afurl->cdnAll($recent, 'img', 'thumb_hash', 'mime_id');




////////////////////////////////////////////////////////////////////////////////
//PROCESS DAYS IN THE MONTH
////////////////////////////////////////////////////////////////////////////////
$first	= 0;
$last	= 0;
foreach ($recent as &$item) {
	$item['day']	= date('d', $item['feature_timestamp']);
	$item['hash']	= bin2hex($item['file_hash']);
	$item['link']	= $afurl->base . '/image/' . $item['hash'] . '?gallery=' . $item['gallery_id'];
	if (!$first) $first = $item['day'];
	$last = $item['day'];
} unset($item);




////////////////////////////////////////////////////////////////////////////////
//ADJUST FOR FIRST MONTH IN CONTEST
////////////////////////////////////////////////////////////////////////////////
for ($i=$first-1; $i>0; $i--) {
	array_unshift($recent, [
		'day'		=> sprintf('%02d', $i),
		'link'		=> $afurl->base . '/featured',
		'img'		=> $afurl->static . '/thumb2/image.svg',
		'name'		=> 'Featured Images',
	]);
}




////////////////////////////////////////////////////////////////////////////////
//ADJUST FIRST DAY OF THE WEEK
////////////////////////////////////////////////////////////////////////////////
for ($i=0; $i<date('w', strtotime($year.'-'.$month.'-01')); $i++) {
	array_unshift($recent, [
		'day'		=> NULL,
		'link'		=> NULL,
		'img'		=> NULL,
		'name'		=> NULL,
	]);
}




////////////////////////////////////////////////////////////////////////////////
//ADJUST FOR TOTAL DAYS IN THE MONTH
////////////////////////////////////////////////////////////////////////////////
for ($i=$last+1; $i<=date('t', strtotime($year.'-'.$month.'-01')); $i++) {
	array_push($recent, [
		'day'		=> sprintf('%02d', $i),
		'link'		=> $afurl->base . '/featured',
		'img'		=> $afurl->static . '/thumb2/image.svg',
		'name'		=> 'Featured Images',
	]);
}




////////////////////////////////////////////////////////////////////////////////
//ADJUST END OF THE CALENDAR
////////////////////////////////////////////////////////////////////////////////
for ($i=1; $i<6; $i++) {
	array_push($recent, [
		'day'		=> NULL,
		'link'		=> NULL,
		'img'		=> NULL,
		'name'		=> NULL,
	]);
}




////////////////////////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!!
////////////////////////////////////////////////////////////////////////////////
$af	->header()
		->load('_virtual.tpl')
			->block('image', $recent)
		->render()
	->footer();
