<?php

////////////////////////////////////////////////////////////////////////////////
// REDIRECT FROM OLD STYLE URL
////////////////////////////////////////////////////////////////////////////////
if (!empty($router->virtual[1]) && ($router->virtual[1] === 'costumes' || $router->virtual[1] === 'photos')) {
	\af\affirm(404, $tag = $db->row(
		['gl'=>'pudl_group_label', 'gr'=>'pudl_group', 'gt'=>'pudl_group_type'],
		[
			'group_label' => $router->virtual[0],
			'gl.group_id=gr.group_id',
			'gr.group_type_id=gt.group_type_id',
		]
	));

	$afurl->redirect([
		'tag',
		$tag['group_type_name'],
		$afurl->clean($tag['group_label']),
	]);
}




////////////////////////////////////////////////////////////////////////////////
// PULL NAME SPACE
////////////////////////////////////////////////////////////////////////////////
\af\affirm(404,
	$namespace = $db->rowId(
		'pudl_group_type',
		'group_type_name',
		$router->virtual[0]
	)
);




////////////////////////////////////////////////////////////////////////////////
// PULL LABEL
////////////////////////////////////////////////////////////////////////////////
$group = $db->row(
	[
		'gr' => _pudl_group(150),
		'gt' => 'pudl_group_type',
		'gl' => 'pudl_group_label',
	],
	[
		'gr.group_type_id=gt.group_type_id',
		'gl.group_id=gr.group_id',
		'gl.group_label'	=> $router->virtual[1],
		'gt.group_type_id'	=> $namespace['group_type_id'],
	]
);




////////////////////////////////////////////////////////////////////////////////
// REDIRECT LABEL
////////////////////////////////////////////////////////////////////////////////
if (empty($group)) {
	\af\affirm(404, $redirect = $db->row(
		[
			'gr' => 'pudl_group',
			'gt' => 'pudl_group_type',
			'gl' => 'pudl_group_label',
			'gx' => 'pudl_group_redirect',
		],
		[
			'gr.group_type_id=gt.group_type_id',
			'gl.group_id=gr.group_id',
			'gl.group_label_id=gx.group_label_id',
			'gx.group_label_old'	=> $router->virtual[1],
			'gt.group_type_id'		=> $namespace['group_type_id'],
		]
	));

	$afurl->redirect([
		'tag',
		$redirect['group_type_name'],
		$redirect['group_label'],
	]);
}




////////////////////////////////////////////////////////////////////////////////
// PROCESS LABEL
////////////////////////////////////////////////////////////////////////////////
$col = "$group[group_type_name]_id";
$af->title = $group['group_label'];

$group['page']	= max($get->int('page'), 0);
$group['text']	= afString::linkify($group['group_label_text']);
$group['istag']	= 1;




////////////////////////////////////////////////////////////////////////////////
// REBASE CURRENT WORKING DIRECTOR
////////////////////////////////////////////////////////////////////////////////
if (count($router->virtual) > 2) {
	$group['page_id'] = array_pop($router->virtual);
	chdir('../');
	$group['subpage'] = 1;
}




////////////////////////////////////////////////////////////////////////////////
// LOAD TAG PERMISSIONS
////////////////////////////////////////////////////////////////////////////////
require('permission.php.inc');
