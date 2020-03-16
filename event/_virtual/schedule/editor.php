<?php

$user->requireAccessStaff('event', $event);

require_once('../event.php.inc');

$af->title	= $event['event_name'] . ' Schedule Editor';



$af->script('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.6.0/moment.min.js');
$af->script($afurl->static . '/fullcalendar/fullcalendar.js');
$af->style( $afurl->static . '/fullcalendar/fullcalendar.css');


$items = $db->rows([
	'sr' => 'pudl_schedule_room',
	'sp' => 'pudl_schedule_panel',
], [
	'sr.schedule_room_id=sp.schedule_room_id',
	'sr.event_id'				=> $event['event_id'],
], [
	'schedule_panel_start',
	'schedule_panel_name',
]);



$calendar = [];
foreach ($items as &$item) {
	$calendar[] = [
		'id'					=> $item['schedule_panel_id'],
		'title'					=> $item['schedule_panel_name'],
		'start'					=> date('r', $item['schedule_panel_start']),
		'end'					=> date('r', $item['schedule_panel_end']),
		'allDay'				=> false,
		'resources'				=> $item['schedule_room_id'],
		'className'				=> 'cpn-panel-' . $item['schedule_panel_type'],
	];
} unset($item);




////////////////////////////////////////////////////////////////////////////////
//DEFAULT BLANK CALENDAR
////////////////////////////////////////////////////////////////////////////////
if (empty($calendar)) $calendar = [[
	'id'						=> 0,
	'title'						=> '',
	'start'						=> date('r', 0),
	'end'						=> date('r', AF_HOUR),
	'allDay'					=> false,
	'resources'					=> 0,
]];




////////////////////////////////////////////////////////////////////////////////
//PULL ALL THE ROOM NAMES
////////////////////////////////////////////////////////////////////////////////
$rooms = $db->selectRows(
	['id'=>'schedule_room_id', 'name'=>'schedule_room_name'],
	'pudl_schedule_room',
	['event_id' => $event['event_id']]
);

if (empty($rooms)) $rooms = [[
	'schedule_room_id'			=> 0,
	'schedule_room_increment'	=> 30,
	'schedule_room_name'		=> 'No Rooms Specified',
]];

$x = 0;
foreach ($rooms as &$room) {
	$room['className'] = 'resource-room-' . ($x++ % 4);
} unset($room);




////////////////////////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////////////////////////
$af	->css('schedule/style.css')
	->header()
		->load('schedule/editor.tpl')
			->field('event',	$event)
			->field('profile',	$profile)
			->block('cal',		$calendar)
			->block('rooms',	$rooms)
		->render()
	->footer();
