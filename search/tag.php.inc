<?php


//Cannot use autocomplete without signing in!
$user->requireLogin();


$text = str_replace('+', ' ', $get->term);


//TODO:	MORE ADVANCED SEARCHING
//		USE MODERN REGEX SEARCHING ON WORD BOUNDARIES
//		USE DASHES REPLACED WITH SPACES


$rows = $db->selectRows([
	'id'	=> 'gl.group_label_id',
	'label'	=> 'gl.group_label',
], [
	'gr'=>'pudl_group',
	'gl'=>'pudl_group_label',
	'gt'=>'pudl_group_type'
], [
	'gl.group_id=gr.group_id',
	'gr.group_type_id=gt.group_type_id',
	'group_type_name'	=> $tagtype,
	'gl.group_label'	=> pudl::like($text),
], [
	'group_label'		=> pudl::notLikeRight($text),
	'group_label'
], 30);


$af->json($rows);
