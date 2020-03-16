<?php

$user->requireAccessStaff('event', $event);




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
//RESTRICTIONS
////////////////////////////////////////////////////////////
$restrict = $db->fieldType('pudl_schedule_panel', 'schedule_panel_restricted');
unset($restrict[0]);




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////
$af	->load('edit.tpl')
	->block('restrict',	$restrict)
	->field('panel',	$panel)
	->block('room',		$db->rowsId('pudl_schedule_room', 'event_id', $panel))
	->block('type',		$db->fieldType('pudl_schedule_panel', 'schedule_panel_type'))
	->render();
