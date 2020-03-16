<?php

$id = $get->id('location');


if ($id === 0) {
	$user->profile(['user_city' => NULL]);
	return;
}


$city = $db->selectRow(
	[
		'*',
		'location' => pudl::raw('CONCAT_WS(" ", city_accent, region_name, country_name)'),
	],
	[
		'ct' => [
			'pudl_city',
			['left'=>['rg'=>'pudl_region'], 'using'=>['country_code','city_region']],
			['left'=>['co'=>'pudl_country'], 'using'=>'country_code'],
		],
	],
	['ct.city_id' => $id]
);
\af\affirm(422, $city);



$user->profile(['user_city' => $city['city_id']]);


echo $city['location'];
