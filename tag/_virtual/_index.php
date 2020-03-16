<?php


////////////////////////////////////////////////////////////
// PULL THE TAG
// - THIS IS COMPATIBILITY WITH AN OLDER
// - VERSION OF COSPIX THAT HAD A DIFFERENT
// - URL FORMAT
////////////////////////////////////////////////////////////
$tag = $db->row(
	[
		'gr' => 'pudl_group',
		'gt' => 'pudl_group_type',
		'gl' => 'pudl_group_label',
	],
	[
		'gr.group_type_id=gt.group_type_id',
		'gl.group_id=gr.group_id',
		[
			'group_label_id'	=> $router->id,
			'group_label'		=> $router->virtual[0],
		]
	]
);




////////////////////////////////////////////////////////////
// REDIRECT TO THE PROPER PAGE
////////////////////////////////////////////////////////////
if (!empty($tag)) $afurl->redirect(
	"$afurl->base/tag/$tag[group_type_name]/" .
	$afurl->clean($tag['group_label'])
);




////////////////////////////////////////////////////////////
// RENDER A LIST OF THINGS FOR A SPECIFIC GROUP TYPE
////////////////////////////////////////////////////////////
if (!ctype_alnum($router->virtual[0])) \af\error(404);
$type = $db->rowId('pudl_group_type', 'group_type_name', $router->virtual[0]);
if (!empty($type)) return require('type.php');




////////////////////////////////////////////////////////////
// NO CASES MATCHED, SO ERROR OUT
////////////////////////////////////////////////////////////
\af\error(404);
