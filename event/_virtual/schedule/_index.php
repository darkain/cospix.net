<?php


if ($af->device() === 'desktop')	\af\device::redetect();
if ($af->device() === 'mobile')		\af\device::set('tablet');


require_once('../event.php.inc');

$af->title	= 'Schedule';




$render['panel'] = $db->rows([
	'sr' => 'pudl_schedule_room',
	'sp' => 'pudl_schedule_panel',
], [
	'sr.schedule_room_id=sp.schedule_room_id',
	'sr.event_id'	=> $event['event_id'],
], [
	'schedule_panel_start',
	'schedule_panel_name',
]);



foreach ($render['panel'] as &$item) {
	$item['day']	= date('l', $item['schedule_panel_start']-(AF_HOUR*4));
	$item['start']	= date('r', $item['schedule_panel_start']);
	$item['end']	= date('r', $item['schedule_panel_end']);
} unset($item);




////////////////////////////////////////////////////////////////////////////////
// RENDER ALL THE THINGS
////////////////////////////////////////////////////////////////////////////////
$af->css('schedule/style.css');
$afurl->jq = 'schedule/_index.tpl';

if ($get->int('jq')) {
	require('render.php.inc');
} else {
	require('_index.php');
}
