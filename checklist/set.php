<?php

//TRANSACTION
$db->begin();

//PULL EXISTING DATA - AND VERIFY PERMISSION
$checklist = $db->rowId('pudl_checklist', 'checklist_id', $get->id());
\af\affirm(404, $checklist);
\af\affirm(401, $user->is($checklist));


//PULL DATA FROM BROWSER
$data	= [];
$text	= $get->stringArray('text');
$check	= $get->stringArray('check');
foreach ($text as $key => $item) {
	$data[] = [
		'text'	=> $item,
		'check'	=> !empty($check[$key]),
	];
}

//INSERT DATA INTO DATABASE
$db->updateId('pudl_checklist',[
	'checklist_name'	=> $get->string('title'),
	'checklist_data'	=> $data,
], 'checklist_id', $checklist);

//TRANSACTION
$db->commit();
