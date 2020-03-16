<?php

$user->requireLogin();


$db->begin();


\af\affirm(404,
	$gathering = $db->rowId('pudl_gathering', 'gathering_id', $get->id())
);

$text = $get->string('text');

$pos = strrpos($text, '(');
if ($pos === false) \af\error(422);

$group	= trim(substr($text, $pos+1, strlen($text)-$pos-2));
$name	= trim(substr($text, 0, $pos-1));

\af\affirm(404,
	$tag = $db->row([
		'gr' => 'pudl_group',
		'gl' => 'pudl_group_label',
		'gt' => 'pudl_group_type'
	], [
		'gl.group_id=gr.group_id',
		'gr.group_type_id=gt.group_type_id',
		'gl.group_label'		=> $name,
		'gt.group_type_name'	=> $group,
	])
);


$db->insert('pudl_object_label', [
	'object_id'					=> $gathering['gathering_id'],
	'object_type_id'			=> $af->type('gathering'),
	'group_label_id'			=> $tag['group_label_id'],
	'object_label_timestamp'	=> $db->time(),
	'object_label_user'			=> $user['user_id'],
], 'object_id=object_id');



$db->commit();
