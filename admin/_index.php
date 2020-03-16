<?php


$dates = [];
for ($i=1990; $i<2020; $i++) {
	$first = strtotime("January 1st $i");
	$last = strtotime('January 1st ' . ($i+1));
	$dates[$i] = $db->count('pudl_event', ['event_start'=>pudl::between($first, $last)]);
}


$af->renderPage(
	'_index.tpl',
	['a' => [
		'user' => [
			'total'		=> $db->count('pudl_user'),
			'active'	=> $db->count('pudl_user', ['user_permission'=>['user','admin']]),
			'invite'	=> $db->count('pudl_invite'),
		],

		'event' => [
			'all'		=> $db->count('pudl_event'),
			'nourl'		=> $db->count('pudl_event', [[['event_website'=>NULL],['event_website'=>'']]]),
			'noimage'	=> $db->count('pudl_event', [[['event_icon'=>NULL],['event_icon'=>'']]]),
			'nogeo'		=> $db->count('pudl_event', [[['event_lat'=>NULL],['event_lat'=>'']]]),
			'nodate'	=> $db->count('pudl_event', [['event_start'=>0,'event_end'=>0]]),
			'notwitter'	=> $db->count('pudl_event', [[['event_twitter'=>NULL],['event_twitter'=>'']]]),
			'novideo'	=> $db->count('pudl_event', [[['event_youtube'=>NULL],['event_youtube'=>'']]]),

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
		],

		'dates' => &$dates,
	]]
);
