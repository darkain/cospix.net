<?php

$af->script('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.6.0/moment.min.js');
$af->script('//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.0.1/fullcalendar.min.js');
$af->style( '//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.0.1/fullcalendar.css');


if ($af->device() === 'desktop')	\af\device::redetect();
if ($af->device() === 'mobile')		\af\device::set('tablet');


require_once('../event.php.inc');




////////////////////////////////////////////////////////////
//GET THE PANEL DATA!
////////////////////////////////////////////////////////////
\af\affirm(404,
	$render['panel'] = $db->row([
		'sp' => 'pudl_schedule_panel',
		'sr' => 'pudl_schedule_room',
	], [
		'sp.schedule_room_id=sr.schedule_room_id',
		'schedule_panel_id'	=> $event['page_id'],
		'event_id'			=> $event['event_id'],
	])
);


$af->title = $render['panel']['schedule_panel_name'];




////////////////////////////////////////////////////////////
//CONFLICTING PANELS!
////////////////////////////////////////////////////////////
$render['conflict'] = [];
if ($render['panel']['schedule_panel_conflict']) {
	$render['conflict'] = $db->rows([
		'sp' => 'pudl_schedule_panel',
		'sr' => 'pudl_schedule_room',
	], [
		'sp.schedule_room_id=sr.schedule_room_id',
		'event_id'					=> $event['event_id'],
		'schedule_panel_conflict'	=> 1,
		'schedule_panel_id'			=> pudl::neq(	$render['panel']['schedule_panel_id'] ),
		'schedule_panel_start'		=> pudl::lteq(	$render['panel']['schedule_panel_end']-1 ),
		'schedule_panel_end'		=> pudl::gt(	$render['panel']['schedule_panel_start'] ),
	], [
		'schedule_panel_start',
		'schedule_panel_name',
	]);
}

foreach ($render['conflict'] as &$item) {
	$item['day']	= date('l', $item['schedule_panel_start']-(AF_HOUR*4));
	$item['start']	= date('r', $item['schedule_panel_start']);
	$item['end']	= date('r', $item['schedule_panel_end']);
} unset($item);




////////////////////////////////////////////////////////////////////////////////
// RENDER ALL THE THINGS
////////////////////////////////////////////////////////////////////////////////
$af->css('schedule/style.css');
$afurl->jq = 'schedule/_virtual.tpl';

if ($get->int('jq')) {
	require('render.php.inc');
} else {
	require('_index.php');
}
