<?php

//TRANSACTION
$db->begin();


//PULL EXISTING DATA - AND VERIFY PERMISSION
$checklist = $db->selectRow(
	['*', 'COLUMN_JSON(checklist_data)'],
	'pudl_checklist',
	['checklist_id' => $get->id()]
);
\af\affirm(404, $checklist);
\af\affirm(401, $user->is($checklist));


//FORCE ARRAY DATATYPE!
if (!is_array($checklist['checklist_data'])) {
	$checklist['checklist_data'] = [];
}


//Append new item
$checklist['checklist_data'][] = [
	'text'	=> 'Do something else awesome!',
	'check'	=> 0,
];


//Update database
$db->updateId('pudl_checklist', [
	'checklist_data' => $checklist['checklist_data'],
], 'checklist_id', $checklist);


//TRANSACTION
$db->commit();
