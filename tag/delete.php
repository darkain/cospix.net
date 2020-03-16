<?php

$user->requireStaff();


$db->begin();


//PULL LABEL
\af\affirm(404,
	$label = $db->rowId('pudl_group_label', 'group_label_id', $get->id())
);


//CHECK IF LABEL IS IN USE, IF SO, BAIL
if ($db->idExists('pudl_object_label', 'group_label_id', $label)) {
	echo 'Cannot delete labels still in use!';
	return;
}


//DELETE LABEL
$db->deleteId('pudl_group_label', 'group_label_id', $label);


//CHECK IF ONLY LABEL IN GROUP, IF SO, DELETE GROUP
if (!$db->idExists('pudl_group_label', 'group_id', $label)) {
	$db->deleteId('pudl_group', 'group_id', $label);
}


$db->commit();
$af->ok();
