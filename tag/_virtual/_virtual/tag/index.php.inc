<?php

/////////////////////////////////////////////
// TAG
/////////////////////////////////////////////
//TODO: merge this into tag.php.inc
$render['tag'] = &$group;




/////////////////////////////////////////////
// PULL ALL LABELS IN GROUP
/////////////////////////////////////////////
$render['tags'] = $db->rows(
	[
		'gl' => 'pudl_group_label',
		'gr' => _pudl_group(50),
		'gt' => 'pudl_group_type'
	],
	[
		'gl.group_id=gr.group_id',
		'gr.group_type_id=gt.group_type_id',
		'gl.group_id'		=> $group['group_id'],
		'gl.group_label_id'	=> pudl::neq($group['group_label_id']),
	],
	'group_label'
);

$afurl->cdnAll($render['tags'], 'img', 'thumb_hash');




/////////////////////////////////////////////
// PHOTOS
/////////////////////////////////////////////
$count = 102;
require('photos/photos.php.inc');




/////////////////////////////////////////////
// OPEN GRAPH
/////////////////////////////////////////////
$image = $db->rowId(['gr'=>_pudl_group(200)], 'group_id', $group);
$og['image']		= $afurl->cdn($image, 'thumb_hash');
//$og['keywords']		= implode(', ', $characters);
$og['description']	= $af->title . ' featuring ' . $og['keywords'];


switch ($group['group_type_name']) {
	case 'universe':	$og['itemtype'] = 'Series'; break;
	case 'series':		$og['itemtype'] = 'Series'; break;
	case 'character':	$og['itemtype'] = 'Person'; break;
	case 'software':	$og['itemtype'] = 'SoftwareApplication'; break;  //TODO: FIX THIS
	case 'camera':		$og['itemtype'] = 'Product'; break;
	case 'lens':		$og['itemtype'] = 'Product'; break;
	default:			$og['itemtype'] = 'Thing'; break;
}


$af->metas([
	['name'=>'twitter:card',		'content'=>'photo'],
	['name'=>'twitter:site',		'content'=>'@cospixnet'],
	['name'=>'twitter:domain',		'content'=>'Cospix.net'],
	['name'=>'twitter:title',		'content'=>"$af->title - $og[title]"],
	['name'=>'twitter:image',		'content'=>&$og['image']],
	['name'=>'twitter:description',	'content'=>&$og['description']],
]);
