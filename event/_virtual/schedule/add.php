<?php

$user->requireAccessStaff('event'. $event);




////////////////////////////////////////////////////////////
//GET ROOM DATA
////////////////////////////////////////////////////////////
\af\affirm(404,
	$rooms = $db->rowsId('pudl_schedule_room', 'event_id', $get->id())
);




////////////////////////////////////////////////////////////
//RESTRICTIONS
////////////////////////////////////////////////////////////
$restrict = $db->fieldType('pudl_schedule_panel', 'schedule_panel_restricted');
unset($restrict[0]);




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////
$af	->load('add.tpl')
	->block('restrict',	$restrict)
	->field('room',		$get('room'))
	->block('rooms',	$rooms)
	->block('type',		$db->fieldType('pudl_schedule_panel', 'schedule_panel_type'))

	->field('panel', [
		'id'	=>		$get->id(),
		'start'	=>		$get('start'),
		'end'	=>		$get('end'),
	])

	->render();
