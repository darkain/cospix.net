<?php


////////////////////////////////////////////////////////////
//ATTEMPT TO GEOLOCATE USER
////////////////////////////////////////////////////////////
$geoip = $geo->geoip();
if (empty($geoip)) $geoip = $geo->usa();




////////////////////////////////////////////////////////////
//PULL THE SEARCH TEXT
////////////////////////////////////////////////////////////
$city = str_replace('+', ' ', $get->search);
if (empty($city)) return;




////////////////////////////////////////////////////////////
//IF TEXT IS SHORT, NARROW GEOGRAPHICAL DISTANCE
////////////////////////////////////////////////////////////
$dist = [0, 1, 3, 7, 15];
$x = strlen($city);
if ($x < 5) {
	$clause = [
		'city_lat' => pudl::between($geoip['latitude' ]-$dist[$x], $geoip['latitude' ]+$dist[$x]),
		'city_lon' => pudl::between($geoip['longitude']-$dist[$x], $geoip['longitude']+$dist[$x]),
	];
} else {
	$clause = [];
}




////////////////////////////////////////////////////////////
//IF TEXT HAS COMMA, SEARCH REGION NAME
////////////////////////////////////////////////////////////
$parts = explode(',', $city);
if (count($parts) > 1) {
	$city	= trim($parts[0]);
	$region	= trim($parts[1]);
	if (!empty($region)) $clause[] = [
		'ct.city_region'	=> $region,
		'rg.region_name'	=> pudl::likeRight($region),
		'co.country_code'	=> $region,
		'co.country_long'	=> $region,
		'co.country_name'	=> pudl::likeRight($region),
	];
}




////////////////////////////////////////////////////////////
//SEARCH FOR ALL THE THINGS!
////////////////////////////////////////////////////////////
$rows = $db->selectRows(
	[
		'city_id',
		'city_accent',
		'region_name',
		'country_name',
		pudl::raw("SQRT(
			POW(69.1 * (city_lat - $geoip[latitude]), 2) +
			POW(69.1 * ($geoip[longitude] - city_lon) * COS(city_lat / 57.3), 2)
		) AS distance"),
	],
	[
		'ct' => [
			'pudl_city',
			['left'=>['rg'=>'pudl_region'], 'using'=>['country_code','city_region']],
			['left'=>['co'=>'pudl_country'], 'using'=>'country_code']
		]
	],
	$clause+[
		'ct.city_accent' => pudl::LikeRight($city),
	],
	[
		'ct.city_accent'	=> pudl::neq($city),
		'city_population'	=> pudl::dsc(),
		'distance'
	],
	15
);




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!
////////////////////////////////////////////////////////////
$af->renderBlock('search.tpl', 'city', $rows);
