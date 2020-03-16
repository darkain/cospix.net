<?php

$user['user_urlx'] = ((int)$user['user_url']) ? '' : $user['user_url'];


$data = $db->selectRow(
	[
		'up.*',
		'location' => pudl::raw('CONCAT_WS(" ", city_accent, region_name, country_name)'),
	],
	[
		'up' => [
			'pudl_user_profile',
			['left'=>['ct' => 'pudl_city'], 'on'=>['up.user_city=ct.city_id']],
			['left'=>['rg'=>'pudl_region'], 'using'=>['country_code','city_region']],
			['left'=>['co'=>'pudl_country'], 'using'=>'country_code'],
		]
	],
	['user_id'=>$user['user_id']]
);


$user->merge($data);





$af->header();
	$af->load('_index.tpl');
		$af->field('prefs', $user->getPreferences());
	$af->render();
$af->footer();
