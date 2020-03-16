<?php
$af->title = 'Account Settings';

if (!$af->prometheus()) {
	require('cospix/_index.php');
	return;
}



//YES, this is needed!
$user->url = ((int)$user->user_url) ? '' : $user->user_url;



$user->merge($db->selectRow(
	[
		'up.*',
		'location' => pudl::raw('CONCAT_WS(" ", city_accent, region_name, country_name)'),
	],
	[
		'up' => [
			'pudl_user_profile',
			['left'=>['ct' => 'pudl_city'],		'on'=>['up.user_city=ct.city_id']],
			['left'=>['rg'=>'pudl_region'],		'using'=>['country_code','city_region']],
			['left'=>['co'=>'pudl_country'],	'using'=>'country_code'],
		]
	],
	['user_id'=>$user]
));



$af->header();
	$af->load('_prometheus.tpl');
		$af->field('prefs', $user->getPreferences());
	$af->render();
$af->footer();
