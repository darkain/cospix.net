<?php

$user->requireAccessStaff('event');



if ($get->dir === 'next') {
	//ADD A YEAR TO THE DATES
	$event['event_start']	+= (AF_YEAR - AF_DAY);
	$event['event_end']		+= (AF_YEAR - AF_DAY);
	$event['group_name']	= $event['event_name'];

	for ($x=2050; $x>1970; $x--) {
		$event['event_name'] = str_replace($x, $x+1, $event['event_name']);
	}

} else if ($get->dir === 'prev') {
	//ADD A YEAR TO THE DATES
	$event['event_start']	-= (AF_YEAR - AF_DAY);
	$event['event_end']		-= (AF_YEAR - AF_DAY);
	$event['group_name']	= $event['event_name'];

	for ($x=1970; $x<2050; $x++) {
		$event['event_name'] = str_replace($x, $x-1, $event['event_name']);
	}

} else {
	\af\error(404);
}

$af->renderPage('../new.tpl', ['new'=>$event]);
