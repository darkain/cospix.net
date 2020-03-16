<?php

//Verify we have two parts in our URL
if (count($router->virtual) !== 2) \af\error(404);

//Verify year
$cal['year'] = (int) $router->virtual[0];
if ($cal['year'] < 1980  ||  $cal['year'] > 2050) \af\error(404);

//Verify month
$cal['month'] = $router->virtual[1];
if (!in_array($cal['month'], [
	'jan', 'feb', 'mar', 'apr', 'may', 'jun',
	'jul', 'aug', 'sep', 'oct', 'nov', 'dec'
])) \af\error(404);



//Set starting date
$start	= strtotime("$cal[month] 1, $cal[year]");

//Set the page's title
$af->title = date('F Y', $start) . ' Convention Calendar';

if (date('W',$start) == 53) $start -= AF_WEEK;

$days	= date('t', $start);

if (date('w',$start) == 1  ||  date('w',$start) == 2) {
	$start	= strtotime(date('Y',$start) . 'W' . date('W',$start)) - (AF_DAY*5);

} else if (date('w', $start) == 0  &&  $cal['month'] == 'jan') {
	//DO NOTHING

} else {
	$start	= strtotime(date('Y',$start) . 'W' . date('W',$start)) + (AF_DAY*2);
}

//Set the ending date
$end	= strtotime("$cal[month] $days, $cal[year]");
if ($cal['month'] === 'dec'  &&  date('W',$end) === '01') {
} else if (date('w',$end) == 1  ||  date('w',$end) == 2) {
	$end = strtotime(date('Y',$end) . 'W' . date('W',$end)) + AF_DAY;
} else {
	$end = strtotime(date('Y',$end) . 'W' . date('W',$end)) + AF_WEEK;
}


require('week.php.inc');


//RENDER ALL THE THINGS!
$af->header();

	$af->load('_virtual.tpl');
		$af->field('cal', $cal);
		if (!$af->prometheus()) {
			$af->block('eventlist', $events);
		} else {
			$af->block('eventlist', []);
		}
	$af->render();

	if ($af->prometheus()) {
		cpn_event::manage($db, $events)
			->separate('week')
			->render($af);
	}

$af->footer();
