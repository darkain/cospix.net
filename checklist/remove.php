<?php

//TRANSACTION
$db->begin();


//PULL EXISTING DATA - AND VERIFY PERMISSION
$checklist = $db->selectRow(
	['*', 'JSON_checklist_data'=>pudl::column_json(pudl::column('checklist_data'))],
	'pudl_checklist',
	['checklist_id' => $get->id()]
);
\af\affirm(404, $checklist);
\af\affirm(401, $user->is($checklist));


//FORCE ARRAY DATATYPE!
if (!is_array($checklist['checklist_data'])) {
	$checklist['checklist_data'] = [];
}


//Remove old item
unset($checklist['checklist_data'][ $get->id('item') ]);


//Update database
$db->updateId('pudl_checklist', [
	'checklist_data' => $checklist['checklist_data'],
], 'checklist_id', $checklist);


//TRANSACTION
$db->commit();
