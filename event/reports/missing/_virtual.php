<?php


\af\affirm(404,
	$router->id > 1970  &&  $router->id < 2050
);


$jan1	= strtotime('January 1st ' . $router->id);
$af->title	= 'Events Without Dates in ' . $router->id;


$af->script($afurl->static . '/js/jquery.tablesorter.min.js');
$af->style( $afurl->static . '/css/theme.blue.css');



$db->unionStart();



	$db->group(
		['ev1.*', 'us.*', 'total' => pudl::count(),],
		[
			'ev1' => [
				'pudl_event',
				['left'=>['ev2'=>'pudl_event'],			'on'=>'ev2.event_group=ev1.event_group'],
				['left'=>['us' =>'pudl_user'],			'on'=>'ev1.event_added_by=us.user_id'],
				['left'=>['ue' =>'pudl_user_event'],	'on'=>'ev1.event_id=ue.event_id'],
			]
		],
		[
			['ev1.event_start'	=> pudl::lt($jan1)],
			['ev1.event_start'	=> pudl::gt($jan1 - AF_YEAR)],
			'ev2.event_id'		=> NULL,
		],
		'ev1.event_id'
	);



	$db->group(
		[
			'ev1.*',
			'us.*',
			'total' => pudl::count()
		],
		[
			'ev1' => [
				'pudl_event',
				['left'=>['us'=>'pudl_user'],			'on'=>'ev1.event_added_by=us.user_id'],
				['left'=>['ue'=>'pudl_user_event'],		'on'=>'ev1.event_id=ue.event_id'],
			]
		],
		[
			['ev1.event_start'	=> pudl::lt($jan1)],
			['ev1.event_start'	=> pudl::gt($jan1 - AF_YEAR)],
			[//TODO: CODE THIS, IT SHOULD NOT BE RAW!!
				pudl::raw("ev1.event_group NOT IN (SELECT event_group FROM cpnet_event ev2 WHERE ev2.event_start >= $jan1 AND ev2.event_group IS NOT NULL)"),
				['ev1.event_id'	=> NULL],
			]
		],
		'ev1.event_group'
	);



$data = $db->unionGroup(
	'event_id',
	['event_start', 'event_end', 'event_name']
)->complete();



$af	->css('../list.css')
	->js('../list.js')
	->header()
		->renderBlock('../list.tpl', 'e', $data)
	->footer();
