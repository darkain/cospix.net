<?php

$af->script($afurl->static . '/js/jquery.tablesorter.min.js');
$af->style( $afurl->static . '/css/theme.blue.css');

$af->title = 'Staffed Events';


$rows = $db->rows([
	'ev' => _pudl_event(200),
	'ue' => 'pudl_user_event',
	'us' => 'pudl_user',
	'sa' => 'pudl_staff',
], [
	'ev.event_id=ue.event_id',
	'ue.user_id=us.user_id',
	'ue.user_id=sa.user_id',
	'ev.event_end>' . $db->time(),
], [
	'ev.event_start',
	'ev.event_end',
	'ev.event_name',
	'us.user_id',
]);


$af->header();
	$af->load('staff.tpl');
		$af->block('e', $rows);
	$af->render();
$af->footer();
