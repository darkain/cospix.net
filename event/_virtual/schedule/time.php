<?php

$user->requireAccessStaff('event', $event);


\af\affirm(404, $panel = $db->rowId(
	'pudl_schedule_panel',
	'schedule_panel_id',
	$get->id()
));


\af\affirm(404, $room = $db->rowId(
	'pudl_schedule_room',
	'schedule_room_id',
	$get('room')
));


$start	= \af\time::get($get('start'));
$end	= \af\time::get($get('end'));

\af\affirm(422, $start,		'NO START TIME');
\af\affirm(422, $end,			'NO END TIME');
\af\affirm(422, $start<$end,	'YOURE GONNA HAVE A BAD TIME');

$db->updateId('pudl_schedule_panel', [
	'schedule_panel_start'	=> $start,
	'schedule_panel_end'	=> $end,
	'schedule_room_id'		=> $room['schedule_room_id'],
], 'schedule_panel_id', $panel);

$af->ok();
