<?php
$user->requireStaff();


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
if (empty($parent)) \af\error(422, 'Unknown Parent Object');




////////////////////////////////////////////////////////////
//PULL CHILD TAG
////////////////////////////////////////////////////////////
$label	= $get->string('label');
$type	= $get->string('type');
$item	= $get->id('item');
$child	= $db->row(
	[
		'gr' => 'pudl_group',
		'gt' => 'pudl_group_type',
		'gl' => 'pudl_group_label',
	],
	[
		'gr.group_type_id=gt.group_type_id',
		'gl.group_id=gr.group_id',
		[
			'gr.group_id' => $item,
			['gl.group_label'=>$label, 'gt.group_type_name'=>$type],
		],
	]
);
if (empty($child)) \af\error(422, 'Unknown Child Object');




////////////////////////////////////////////////////////////
//CHECK IF ITEM ALREADY EXISTS
////////////////////////////////////////////////////////////

if ($db->clauseExists('pudl_group_relate', array(
	'group_parent'	=> $parent['group_id'],
	'group_child'	=> $child['group_id'],
))) { echo 'Already Linked!'; return; }

if ($db->clauseExists('pudl_group_relate', array(
	'group_parent'	=> $child['group_id'],
	'group_child'	=> $parent['group_id'],
))) { echo 'Already Linked!'; return; }




////////////////////////////////////////////////////////////
//INSERT OBJECT!
////////////////////////////////////////////////////////////
$db->insert('pudl_group_relate', [
	'group_parent'	=> $parent['group_id'],
	'group_child'	=> $child['group_id'],
]);




////////////////////////////////////////////////////////////
//REDIRECT
////////////////////////////////////////////////////////////
echo "<script>document.location=('$afurl->base/tag/" .
	rawurlencode(strtolower($parent['group_label'])) .
	"')</script>";
