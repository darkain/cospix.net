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


$db->deleteId('pudl_checklist', 'checklist_id', $checklist);


//TRANSACTION
$db->commit();
