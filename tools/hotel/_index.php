<?php

$af->title = 'Hotel Rate Sharing Calculator';

$block = [0,1,2,3,4,5,6,7,8,9];

$hash = $get->hash();
$row  = $db->rowId('pudl_tool_hotel', 'hash', pudl::unhex($hash));
$data = (!empty($row['json'])) ? json_decode($row['json'],true) : [];

$af->header();
	$af->load('_index.tpl');
		$af->field('page',	$row);
		$af->block('block',	$block);
		$af->field('data',	$data);
	$af->render();
$af->footer();
