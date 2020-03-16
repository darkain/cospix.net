<?php
$user->requireStaff();




////////////////////////////////////////////////////////////
//BEGIN TRANSACTION
////////////////////////////////////////////////////////////
$db->begin();




////////////////////////////////////////////////////////////
//PULL PARENT TAG
////////////////////////////////////////////////////////////
$parent = $db->row(
	[
		'gr' => 'pudl_group',
		'gt' => 'pudl_group_type',
		'gl' => 'pudl_group_label',
	],
	[
		'gl.group_label_id' => $get->id(),
		'gr.group_type_id=gt.group_type_id',
		'gl.group_id=gr.group_id',
	]
);
\af\affirm(422, $parent, 'Unknown Parent Object');




////////////////////////////////////////////////////////////
//IF BLANK LABEL, RETURN WITHOUT CHANGES
////////////////////////////////////////////////////////////
$label = afString::slash($get('text'));
echo $label;
if (empty($label)) {
	echo $parent['group_label'];
	return;
}




////////////////////////////////////////////////////////////
//PULL CHILD TAG
////////////////////////////////////////////////////////////
$child = $db->row(
	[
		'gr' => 'pudl_group',
		'gt' => 'pudl_group_type',
		'gl' => 'pudl_group_label',
	],
	[
		'gr.group_type_id=gt.group_type_id',
		'gl.group_id=gr.group_id',
		'gl.group_label'	=> $label,
		'gr.group_type_id'	=> $parent['group_type_id'],
	]
);
if ($parent['group_label_id'] === $child['group_label_id']) return;




////////////////////////////////////////////////////////////
//CHILD DOESNT EXIST, SO NO MERGING IS NEEDED
////////////////////////////////////////////////////////////
if (empty($child)) {
	$db->insert('pudl_group_redirect', [
		'group_label_id'	=> $parent['group_label_id'],
		'group_label_old'	=> $parent['group_label'],
	]);

	$db->updateId('pudl_group_label', [
		'group_label'		=> $get->string('text')
	], 'group_label_id', $parent);
	$db->commit();

	return;
}




////////////////////////////////////////////////////////////
//CHILD DOES EXIST, MERGE PARENT INTO CHILD
////////////////////////////////////////////////////////////
//TODO switch this over to object_label and gallery_label
/*
$column = "$parent[group_type_name]_id";

switch ($column) {
	case 'series_id':
	case 'character_id':
	case 'outfit_id':
		$db->update('pudl_gallery',
			[$column => $child['group_label_id']],
			[$column => $parent['group_label_id']]
		);
	break;
}
*/




////////////////////////////////////////////////////////////
//REDIRECT TO NEW GROUP
////////////////////////////////////////////////////////////
$db->insert('pudl_group_redirect', [
	'group_label_id'	=> $child['group_label_id'],
	'group_label_old'	=> $parent['group_label'],
]);




////////////////////////////////////////////////////////////
//UPDATE OBJECTS TO NEW GROUP
////////////////////////////////////////////////////////////
$result = $db->select(
	['file_hash', 'object_id', 'object_type_id'],
	'pudl_object_label',
	['group_label_id' => $parent['group_label_id']]
);

while ($data = $result()) {
	if (!empty($data['file_hash'])) {
		cpnTag::insertHash(
			$data['file_hash'],
			$data['object_type_id'],
			$child['group_label_id']
		);
	} else {
		cpnTag::insertObject(
			$data['object_id'],
			$data['object_type_id'],
			$child['group_label_id']
		);
	}
}

$result->free();




////////////////////////////////////////////////////////////
//UPDATE RELATED CHILDREN TO NEW GROUP
////////////////////////////////////////////////////////////
$result = $db->select(
	'group_parent',
	'pudl_group_relate',
	['group_child' => $parent['group_id']]
);

while ($data = $result->row()) {
	$db->insert('pudl_group_relate', [
		'group_parent'	=> $data['group_parent'],
		'group_child'	=> $child['group_id'],
	], true);
}

$result->free();




////////////////////////////////////////////////////////////
//UPDATE RELATED CHILDREN TO NEW GROUP
////////////////////////////////////////////////////////////
$result = $db->select(
	'group_child',
	'pudl_group_relate',
	['group_parent'=>$parent['group_id']]
);

while ($data = $result->row()) {
	$db->insert('pudl_group_relate', [
		'group_parent'	=> $child['group_id'],
		'group_child'	=> $data['group_child'],
	], true);
}

$result->free();




////////////////////////////////////////////////////////////
//DELETE OLD AND NOW EMPTY GROUP
////////////////////////////////////////////////////////////
$db->delete('pudl_group_label', [
	'group_label_id' => $parent['group_label_id']
]);




////////////////////////////////////////////////////////////
//COMMIT TRANSACTION
////////////////////////////////////////////////////////////
$db->commit();
