<?php


$af->script($afurl->static . '/js/jquery.tablesorter.min.js');
$af->style( $afurl->static . '/css/theme.blue.css');


$year = date('Y') - 1;

$af->title = $year . ' Events';


$events = $db->group(
	['ev.*', 'us.*'],
	[
		'ev' => ['pudl_event',
			['left'=>['ex'=>'pudl_event'], 'on'=>[
				'ev.event_group=ex.event_group',
				'ex.event_start' => pudl::between(
					strtotime('January 1st ' . ($year + 1)),
					strtotime('January 1st ' . ($year + 2))-1
				)
			]]
		],
		'us' => 'pudl_user',
		'ue' => 'pudl_user_event',
	],
	[
		'ev.event_added_by=us.user_id',
		'ev.event_id=ue.event_id',
		'ex.event_id'		=> NULL,
		'ev.event_start'	=> pudl::between(
			strtotime('January 1st ' . ($year + 0)),
			strtotime('January 1st ' . ($year + 1))-1
		)
	],
	'ev.event_id',
	[
		pudl::raw('COUNT(*) DESC'),
		'ev.event_name'
	]
)->complete();


$af	->css('list.css')
	->js('list.js')
	->header()
		->load('list.tpl')
			->block('e', $events)
		->render()
	->footer();
