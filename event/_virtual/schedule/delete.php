<?php

$user->requireAccessStaff('event', $event);




////////////////////////////////////////////////////////////
//GET THE PANEL DATA!
////////////////////////////////////////////////////////////
\af\affirm(404,
	$panel = $db->rowId(
		'pudl_schedule_panel',
		'schedule_panel_id',
		$get->id()
	)
);




////////////////////////////////////////////////////////////
//DELETE THE THING
////////////////////////////////////////////////////////////
$db->deleteId(
	'pudl_schedule_panel',
	'schedule_panel_id',
	$panel
);