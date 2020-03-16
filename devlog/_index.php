<?php

$af->title = 'Development Log';


$rows = $db->rows(
	['dl'=>'pudl_devlog', 'us'=>_pudl_user(50)],
	'dl.log_user=us.user_id',
	['log_id'=>pudl::dsc()]
);


foreach ($rows as &$row) {
	$row['ym'] = date('F Y', $row['log_time']);
	$row['log_text'] = afString::linkify($row['log_text']);
} unset($row);


$af->header();

	$af->load('_index.tpl');
		$af->block('log', $rows);
	$af->render();

$af->footer();
