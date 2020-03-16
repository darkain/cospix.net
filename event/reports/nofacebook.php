<?php

$af->script($afurl->static . '/js/jquery.tablesorter.min.js');
$af->style( $afurl->static . '/css/theme.blue.css');


$af->title = 'Events without Facebook';

$af->header();

	$af->renderBlock('list.tpl', 'e',
		$db->selectRows(
			['ev.*', 'us.*'],
			['ev'=>['pudl_event',
				['left'=>['us'=>'pudl_user'],'on'=>'event_added_by=user_id'],
				['left'=>['es'=>'pudl_event_social'], 'on'=>[
					'ev.event_id=es.event_id',
					'es.social_type'=>'Facebook',
				]]
			]],
			['social_type'=>NULL]
		)
	);

$af->footer();
