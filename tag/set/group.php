<?php
$user->requireStaff();


////////////////////////////////////////////////////////////
//BEGIN TRANSACTION
////////////////////////////////////////////////////////////
$db->begin();




////////////////////////////////////////////////////////////
//PULL PARENT TAG
////////////////////////////////////////////////////////////
$parent = $db->row([
	'gr' => 'pudl_group',
	'gt' => 'pudl_group_type',
	'gl' => 'pudl_group_label',
], [
	'gr.group_type_id=gt.group_type_id',
	'gl.group_id=gr.group_id',
	'gr.group_id' => $get->id(),
]);
\af\affirm(422, $parent, 'Unknown Parent Object');




////////////////////////////////////////////////////////////
//PULL CHILD TAG
////////////////////////////////////////////////////////////
$label = $get->string('label');
$child = $db->row([
	'gr' => 'pudl_group',
	'gt' => 'pudl_group_type',
	'gl' => 'pudl_group_label',
], [
	'gr.group_type_id=gt.group_type_id',
	'gl.group_id=gr.group_id',
	'gl.group_label'	=> $label,
	'gr.group_type_id'	=> $parent['group_type_id'],
]);
\af\affirm(422, $child, 'Unknown Child Object');




////////////////////////////////////////////////////////////
//ARE THESE TWO OBJECTS ALREADY GROUPED TOGETHER?
////////////////////////////////////////////////////////////
if ($parent['group_id'] === $child['group_id']) return;




////////////////////////////////////////////////////////////
//UPDATE EXISTING TAGS TO NEW GROUP
////////////////////////////////////////////////////////////
$db->updateId('pudl_group_label', [
	'group_id' => $parent['group_id']
], 'group_id', $child);




////////////////////////////////////////////////////////////
//UPDATE OBJECTS TO NEW GROUP
////////////////////////////////////////////////////////////
/*
$result = $db->select(
	['file_has', 'object_id', 'object_type_id'],
	'pudl_object_label',
	['group_label_id' => $child['group_label_id']]
);

while ($data = $result()) {
	if (!empty($data['file_hash'])) {
		cpnTag::insertHash(
			$data['file_hash'],
			$data['object_type_id'],
			$parent['group_label_id']
		);
	} else {
		cpnTag::insertObject(
			$data['object_id'],
			$data['object_type_id'],
			$parent['group_label_id']
		);
	}
}

$result->free();
*/




////////////////////////////////////////////////////////////
//UPDATE RELATED CHILDREN TO NEW GROUP
////////////////////////////////////////////////////////////
$result = $db->select(
	'group_parent',
	'pudl_group_relate',
	['group_child' => $child['group_id']]
);

while ($data = $result->row()) {
	$db->insert('pudl_group_relate', [
		'group_parent'	=> $data['group_parent'],
		'group_child'	=> $parent['group_id'],
	], true);
}

$result->free();




////////////////////////////////////////////////////////////
//UPDATE RELATED CHILDREN TO NEW GROUP
////////////////////////////////////////////////////////////
$result = $db->select(
	'group_child',
	'pudl_group_relate',
	['group_parent' => $child['group_id']]
);

while ($data = $result->row()) {
	$db->insert('pudl_group_relate', [
		'group_parent'	=> $parent['group_id'],
		'group_child'	=> $data['group_child'],
	], true);
}

$result->free();




////////////////////////////////////////////////////////////
//DELETE OLD AND NOW EMPTY GROUP
////////////////////////////////////////////////////////////
$db->delete('pudl_group', [
	'group_id' => $child['group_id'],
]);




////////////////////////////////////////////////////////////
//COMMIT TRANSACTION
////////////////////////////////////////////////////////////
$db->commit();
