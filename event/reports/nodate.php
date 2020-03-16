<?php

$af->script($afurl->static . '/js/jquery.tablesorter.min.js');
$af->style( $afurl->static . '/css/theme.blue.css');


$af->title = 'Events without Dates';

$af->header();

	$af->renderBlock('list.tpl', 'e',
		$db->rows(
			['ev'=>['pudl_event',['left'=>'pudl_user','on'=>'event_added_by=user_id']]],
			[['event_start=0','event_end=0']]
		)
	);

$af->footer();
