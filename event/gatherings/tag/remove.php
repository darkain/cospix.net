<?php

$user->requireLogin();

$gathering = $db->rowId('pudl_gathering', 'gathering_id', $get->id('item'));
\af\affirm(404, $gathering);


$db->begin();


$tag = $db->row([
	'gr' => 'pudl_group',
	'gl' => 'pudl_group_label',
	'gt' => 'pudl_group_type'
], [
	'gl.group_id=gr.group_id',
	'gr.group_type_id=gt.group_type_id',
	'gl.group_label_id' => $get->id(),
]);
\af\affirm(404, $tag);


$db->delete('pudl_object_label', [
	'object_id'			=> $gathering['gathering_id'],
	'object_type_id'	=> $af->type('gathering'),
	'group_label_id'	=> $tag['group_label_id'],
]);


$db->commit();


$af->ok();
