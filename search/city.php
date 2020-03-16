<?php


$city = $get->search('term');
if (empty($city)) return $af->json([]);



$geoip = $geo->geoip();
if (empty($geoip)) $geoip = $geo->usa();


$distance = [];
switch (strlen($city)) {
	case 1: $distance = [
		'city_lat<' . ($geoip['latitude']+1),
		'city_lat>' . ($geoip['latitude']-1),
		'city_lon<' . ($geoip['longitude']+1),
		'city_lon>' . ($geoip['longitude']-1),
	]; break;

	case 2: $distance = [
		'city_lat<' . ($geoip['latitude']+3),
		'city_lat>' . ($geoip['latitude']-3),
		'city_lon<' . ($geoip['longitude']+3),
		'city_lon>' . ($geoip['longitude']-3),
	]; break;

	case 3: $distance = [
		'city_lat<' . ($geoip['latitude']+7),
		'city_lat>' . ($geoip['latitude']-7),
		'city_lon<' . ($geoip['longitude']+7),
		'city_lon>' . ($geoip['longitude']-7),
	]; break;

	case 4: $distance = [
		'city_lat<' . ($geoip['latitude']+15),
		'city_lat>' . ($geoip['latitude']-15),
		'city_lon<' . ($geoip['longitude']+15),
		'city_lon>' . ($geoip['longitude']-15),
	]; break;
}


$rows = $db->selectRows(
	[
		'city_id',
		'label' => pudl::raw('CONCAT_WS(" ", city_accent, region_name, country_name)'),
		pudl::raw("SQRT(
			POW(69.1 * (city_lat - $geoip[latitude]), 2) +
			POW(69.1 * ($geoip[longitude] - city_lon) * COS(city_lat / 57.3), 2)
		) AS distance"),
	],
	[
		'ct' => [
			'city',
			['left'=>['rg'=>'region'], 'using'=>['country_code','city_region']],
			['left'=>['co'=>'country'], 'using'=>'country_code']
		]
	],
	$distance+[
		'ct.city_accent'	=> pudl::LikeRight($city),
	],
	[
		'ct.city_accent'	=> pudl::neq($city),
		'city_population'	=> pudl::dsc(),
		'distance'
	],
	15
);

$af->json($rows);
