<?php




////////////////////////////////////////////////////////////
//RECENTLY FEATURED IMAGES
////////////////////////////////////////////////////////////
$result	= $db->cache(AF_HOUR)->group([
	pudl::raw($today.'-FLOOR((fe.feature_timestamp) / ('.AF_DAY.')) AS rank'),
	'fe.file_hash',		'fe.feature_timestamp',
	'us.user_name',		'us.user_url',	'us.user_id',
	'th.thumb_hash',
	'ga.gallery_id',
	'fl.file_width',
	'fl.file_height',
	'fl.file_average',
	'mime' => 'fl.mime_id',
], [
	'fe' => 'pudl_feature',
	'fl' => 'pudl_file',
	'ga' => 'pudl_gallery',
	'us' => 'pudl_user',
	'gi' => _pudl_gallery_image($thumb),
], [
	cpnFilterBanned(),
	'fe.file_hash=gi.file_hash',
	'fe.user_id=ga.user_id',
	'us.user_id=ga.user_id',
	'gi.gallery_id=ga.gallery_id',
	'th.file_hash=fl.file_hash',
], [
	'gi.file_hash',
], [
	'fe.feature_timestamp'=>pudl::dsc(),
]);


if (!$result->count()) return;


$value	= 998 / $result->count();
$count	= 1;


while ($item = $result()) {
	if ($item['rank'] < $minrank) continue;

	$images[]		= $item['file_hash'];

	$item['width']	= $af->discoverWidth($item);

	$item['name']	= date('F jS', $item['feature_timestamp']) . ' Photo of the Day';

	//TODO: URLS ARE GETTING AN EXTRA / AT THE END, AND SHOULDNT BE!
	$item['url']	= 'image/' . bin2hex($item['file_hash']) . '?gallery=' . $item['gallery_id'];

	$item['img']	= $afurl->cdn($item);
	if (empty($item['img'])) $item['img'] = $afurl->static . '/thumb2/image.svg';

	$item['icon']	= 'image.svg';

	$rank			= ($count * $value) . 'd';
	$count			+= 10;
	$data[$rank]	= $item;
}

$result->free();

