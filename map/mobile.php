<?php


$og['viewport'] = 'width=200, initial-scale=1.0, user-scalable=no';

$af->headerHtml();
	$af->load('mobile.tpl');
		$af->field('gmap', $geo->center($user, $get));
	$af->render();
$af->footerHtml();
