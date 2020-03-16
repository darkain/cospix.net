<?php
//Cannot use autocomplete without signing in!
$user->requireLogin();

//$grouptype
if (!empty($grouptype)) {
	$column = "gl.group_label label";
	$clause = ['group_type_name' => $grouptype];
} else {
	$column = "CONCAT(gl.group_label, ' (', gt.group_type_name, ')') AS label";
	$clause = [];
}

$text = $get->search('term');

$rows = $db->selectRows(
	$column,
	['gr'=>'pudl_group', 'gl'=>'pudl_group_label', 'gt'=>'pudl_group_type'],
	$clause+[
		'gl.group_id=gr.group_id',
		'gr.group_type_id=gt.group_type_id',
		'gl.group_label' => pudl::like($text),
	], [
		'group_label'=>pudl::notLikeRight($text),
		'group_label'
	],
	30
);

$af->json($rows);
