<?php

$af->title = ucwords($router->virtual[0]) . ' Tags';


$size		= 500;
$template	= '_prometheus.tpl';
$block		= 'item';



////////////////////////////////////////////////////////////////////////////////
//BAIL IF UNIVERSE
////////////////////////////////////////////////////////////////////////////////
if ($router->virtual[0] === 'universe') {
	return require('universe.php');
}




////////////////////////////////////////////////////////////////////////////////
//SEARCH CLAUSE
////////////////////////////////////////////////////////////////////////////////
$x = -1;
$clause = [];
if ($get->search) {
	$search = preg_split('/[\s,-]+/', $get->search);
	foreach ($search as $item) {
		$clause[$x--] = [
			'gl.group_label' => pudl::regexp(pudl::raw('[[:<:]]'), $item)
		];
	}
}

if (empty($clause)) {
	$clause[] = [
		['ga.gallery_timestamp'	=> pudl::gt( \af\time::from(AF_WEEK, AF_HOUR) )],
	];
}




////////////////////////////////////////////////////////////////////////////////
//QUERY DATABASE
////////////////////////////////////////////////////////////////////////////////
$type = $af->type('gallery');

$tags	= new cpn_collection($db, 'cpn_tag',
	$db->cache(AF_HOUR)->group(
		[
			'gl.group_label',
			'gt.group_type_name',
			'th.thumb_hash',
			'th.file_hash',
			'fl.file_width',
			'fl.file_height',
			'fl.file_average',
			'fl.mime_id',
			'total' => pudl::count('gl.group_label_id'),
		], [
			'ol' => 'pudl_object_label',
			'ga' => 'pudl_gallery',
			'gl' => 'pudl_group_label',
			'gx' => 'pudl_group_label',
			'gt' => 'pudl_group_type',
			'fl' => 'pudl_file',
			'gr' => _pudl_group($size),
		], $clause + [
			'ol.group_label_id=gl.group_label_id',
			'th.file_hash=fl.file_hash',
			'gx.group_id=gr.group_id',
			'gl.group_id=gr.group_id',
			'ga.gallery_id=ol.object_id',
			'gt.group_type_id=gr.group_type_id',
			'ol.object_type_id'		=> $type,
			'gt.group_type_name'	=> $router->virtual[0],
		],
		'gl.group_id',
		['total' => pudl::desc()],
		50
	)
);




////////////////////////////////////////////////////////////////////////////////
//CALCULATE WIDTH/HEIGHT RATIO
////////////////////////////////////////////////////////////////////////////////
$tags->prometheus();




////////////////////////////////////////////////////////////////////////////////
//PREP LEGACY CONTENT
////////////////////////////////////////////////////////////////////////////////
$letters = array_combine(range('a', 'z'), range('A', 'Z'));
$letters['0'] = '#';
$letters['*'] = '@';




////////////////////////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////////////////////////
if ($af->prometheus()  &&  $get('jq')) {
	$af	->load('discover/_index.tpl')
			->field('search',	$get->search)
			->block($block,		$tags)
		->render();

} else {
	$af	->header()
		->load($template)
			->field('search',	$get->search)
			->block('letters',	$letters)
			->block($block,		$tags)
			->block('nttags',	[])
		->render()
	->footer();
}
