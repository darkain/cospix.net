<?php

$user->requireAccessStaff('event', $event);


////////////////////////////////////////////////////////////
//GET NEW INFO AND VALIDATE IT
////////////////////////////////////////////////////////////
$start	= \af\time::get($get('start'));
$end	= \af\time::get($get('end'));

\af\affirm(422, $start,		'NO START TIME');
\af\affirm(422, $end,			'NO END TIME');
\af\affirm(422, $start<$end,	'YOURE GONNA HAVE A BAD TIME');
\af\affirm(422, $get('name'),	'Y U NO HAS NAME!?');




////////////////////////////////////////////////////////////
//GET THE PANEL DATA!
////////////////////////////////////////////////////////////
\af\affirm(404,
	$panel = $db->row([
		'sp' => 'pudl_schedule_panel',
		'sr' => 'pudl_schedule_room',
	], [
		'sp.schedule_room_id=sr.schedule_room_id',
		'schedule_panel_id' => $get->id(),
	])
);




////////////////////////////////////////////////////////////
//GET THE ROOM DATA!
////////////////////////////////////////////////////////////
\af\affirm(404,
	$room = $db->rowId(
		'pudl_schedule_room',
		'schedule_room_id',
		$get('room')
	)
);




////////////////////////////////////////////////////////////
//UPDATE TEH PANELZ
////////////////////////////////////////////////////////////
$id = $db->updateId('pudl_schedule_panel', [
	'schedule_room_id'			=> $room['schedule_room_id'],
	'schedule_panel_start'		=> $start,
	'schedule_panel_end'		=> $end,
	'schedule_panel_restricted'	=> $get('restrict'),
	'schedule_panel_conflict'	=> $get->int('conflict'),
	'schedule_panel_type'		=> $get('type'),
	'schedule_panel_name'		=> $get('name'),
	'schedule_panel_text'		=> $get->stringNull('text'),
], 'schedule_panel_id', $panel);




////////////////////////////////////////////////////////////
//OUTPUT THE NEW NAME
////////////////////////////////////////////////////////////
echo $get('name');
