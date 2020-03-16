<?php


$af->script($afurl->static . '/js/jquery.tablesorter.min.js');
$af->style( $afurl->static . '/css/theme.blue.css');


$af->title = $router->id . ' Events';


$events = $db->rows(
	[
		'ev' => ['pudl_event',
			['left'=>['us'=>'pudl_user'], 'on'=>'ev.event_added_by=us.user_id']
		]
	],
	['event_start' => pudl::between(
		strtotime('January 1st ' . ($router->id + 0)),
		strtotime('January 1st ' . ($router->id + 1))-1
	)],
	['event_start', 'event_end', 'event_name']
);


$af	->css('../list.css')
	->js('../list.js')
	->header()
		->load('../list.tpl')
			->block('e', $events)
		->render()
	->footer();
