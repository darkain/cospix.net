<?php
$user->requireStaff();

$id		= $get->id();
$item	= $get->id('item');

$db->delete('pudl_group_relate', [
	'group_parent'	=> $id,
	'group_child'	=> $item,
]);

$db->delete('pudl_group_relate', [
	'group_parent'	=> $item,
	'group_child'	=> $id,
]);
