<?php


$af->title = 'Event Reports';


$dates = [];
for ($i=2000; $i<=2020; $i++) {
	$dates[$i] = $db->count('pudl_event', [
		'event_start' => pudl::between(
			strtotime('January 1st ' . ($i + 0)),
			strtotime('January 1st ' . ($i + 1))-1
		),
	]);
}


$report = [
	'all'		=> $db->count('pudl_event'),
	'nourl'		=> $db->count('pudl_event', [[['event_website'	=> NULL],	['event_website'	=>'']]]),
	'noimage'	=> $db->count('pudl_event', [[['event_icon'		=> NULL],	['event_icon'		=>'']]]),
	'nogeo'		=> $db->count('pudl_event', [[['event_lat'		=> NULL],	['event_lat'		=>'']]]),
	'nodate'	=> $db->count('pudl_event', [[['event_start'	=>    0],	['event_end'		=> 0]]]),
	'notwitter'	=> $db->count('pudl_event', [[['event_twitter'	=> NULL],	['event_twitter'	=>'']]]),
	'novideo'	=> $db->count('pudl_event', [[['event_youtube'	=> NULL],	['event_youtube'	=>'']]]),
	'canceled'	=> $db->count('pudl_event', pudl::find('event_details', 'canceled')),

	'nofacebook'=> $db->count(
		['ev'=>['pudl_event',
			['left'=>['es'=>'pudl_event_social'], 'on'=>[
				'ev.event_id=es.event_id',
				'es.social_type'=>'Facebook',
			]]
		]],
		['social_type'=>NULL]
	),

	'noyoutube'=> $db->count(
		['ev'=>['pudl_event',
			['left'=>['es'=>'pudl_event_social'], 'on'=>[
				'ev.event_id=es.event_id',
				'es.social_type'=>'YouTube',
			]]
		]],
		['social_type'=>NULL]
	),
];


$af	->js('_index.js')
	->css('_index.css')
	->header()
		->load('_index.tpl')
			->field('report',	$report)
			->block('dates',	$dates)
		->render()
	->footer();
