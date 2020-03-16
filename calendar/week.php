<?php

//Verify year
$cal['year'] = $get->id('year');
if ($cal['year'] < 1980  ||  $cal['year'] > 2050) \af\error(404);

//Fix week
$cal['week'] = $get->id('week');
if ($cal['week'] < 10) $cal['week'] = '0' . $cal['week'];

//Dates
$start	= strtotime("Y$cal[year]W$cal[week]") + (AF_DAY*2);
$end	= $start + AF_WEEK;

//Month
$cal['month'] = date('m', $start);

//Process dates
require('week.php.inc');

//RENDER ALL THE THINGS!!
$af->headerHtml();
	$af->render('hack.tpl');
	$af->load('week.tpl');
		$af->block('eventlist', $events);
	$af->render();
$af->footerHtml();
