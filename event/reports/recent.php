<?php

$af->script($afurl->static . '/js/jquery.tablesorter.min.js');
$af->style( $afurl->static . '/css/theme.blue.css');


$af->title = 'Recently Added Events';

$af->header();

	$af->renderBlock('list.tpl', 'e',
		$db->selectRows(
			'*',
			['ev'=>['pudl_event',['left'=>'pudl_user','on'=>'event_added_by=user_id']]],
			false,
			['event_id'=>pudl::dsc()],
			100
		)
	);

$af->footer();
