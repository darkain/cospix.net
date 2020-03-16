<?php

$bound  = $get->string('b');
$bound  = str_replace(array('(',')'), '', $bound);
$bounds = explode(',', $bound);
if (count($bounds) < 4) $afurl->redirect("$afurl->base/profile/map");



//FIXES ISSUES WITH INTERNATIONAL DATE LINE!!
if ($bounds[1] > $bounds[3]) {
	$clause = [
		'ct.city_lat'=>pudl::between($bounds[0], $bounds[2]),
		['ct.city_lon'=>pudl::gteq($bounds[1]), 'city_lon'=>pudl::lteq($bounds[3])],
	];
} else {
	$clause = [
		'ct.city_lat'=>pudl::between($bounds[0], $bounds[2]),
		'ct.city_lon'=>pudl::between($bounds[1], $bounds[3]),
	];
}



$result = $db->group(
	[
		'sort'		=> pudl::count(),
		'id'		=> 'us.user_id',
		'value'		=> 'us.user_name',
		'url'		=> 'us.user_url',
		'location'	=> pudl::raw('CONCAT_WS(", ", ct.city_accent, rg.region_name)'),
		'th.*',
	],
	[
		'us' => array_merge(_pudl_user(50),[
			['left'=>'pudl_gallery', 'using'=>'user_id']
		]),
		'up' => 'pudl_user_profile',
		'ct' => ['pudl_city',
			['left'=>['rg'=>'pudl_region'], 'using'=>['country_code','city_region']],
		],
	],
	array_merge($clause, [
		'us.user_id=up.user_id',
		'up.user_city=ct.city_id',
		cpnFilterBanned(),
	]),
	'us.user_id',
	['sort'=>pudl::dsc(), 'us.user_name'],
	50
);

$data = $result->rows();
$result->free();

foreach ($data as $key => &$val) {
	$val['img'] = $afurl->cdn($val, 'thumb_hash');
	if (empty($val['url'])) $val['url'] = $val['id'];
} unset($val);


$af->renderBlock('bounds.tpl', 'b', $data);
