<?php

require('image.php.inc');




////////////////////////////////////////////////////////////
//SEARCH FOR THE THINGS
////////////////////////////////////////////////////////////
$tags = $db->selectRows(
	'*',
	['gl'=>'pudl_group_label', 'gr'=>_pudl_group(50), 'gt'=>'pudl_group_type'],
	[
		'gl.group_id=gr.group_id',
		'gr.group_type_id=gt.group_type_id',
		'gt.group_type_name IN ("universe", "series", "character", "outfit")',
		'gl.group_label' => pudl::likeRight($get('search')),
	],
	false,
	12
);

$afurl->cdnAll($tags, 'img', 'thumb_hash');



////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS
////////////////////////////////////////////////////////////
$af->load('body.tpl');
	$af->field('image',	$image);
	$af->block('tag',	$tags);
$af->render();
