<?php

$letter			= $router->virtual[1];
$group			= $router->virtual[0];

$size			= 200;
$block			= 'tags';

$template		= 'taglist.tpl';

if ($af->prometheus()) {
	$type		= ['gallery', 'costume'];
	$size		= 500;
	$template	= '_cospix/discover_page.tpl';
	$block		= 'item';
}




/////////////////////////////////////////////
// PICK WHICH TAGS WE'RE WORKING WITH
/////////////////////////////////////////////
if (preg_match('/^[a-z]$/i', $letter)) {
	$clause = ['group_label' => pudl::likeRight($letter)];
	$af->title  = ucwords($group) . " starting with letter '" . strtoupper($letter) . "'";

} else if ($letter === '0') {
	$clause = ['group_label' => pudl::regexp(pudl::raw('^[0-9]'))];
	$af->title  = ucwords($group) . " starting with Numbers";

} else if ($letter === '*') {
	$clause = ['group_label' => pudl::notRegexp(pudl::raw('^[0-9a-zA-Z]'))];
	$af->title  = ucwords($group) . " starting with Special Characters";

} else {
	\af\error(404);
}




/////////////////////////////////////////////
// PULL THE TAGS WITH THUMBNAILS
/////////////////////////////////////////////
$tags = $db->rows([
	'gl' => 'pudl_group_label',
	'gr' => _pudl_group($size),
	'gt' => 'pudl_group_type',
], $clause+[
	'thumb_hash'			=> pudl::neq(NULL),
	'gt.group_type_name'	=> $group,
	'gl.group_id=gr.group_id',
	'gr.group_type_id=gt.group_type_id',
], [
	'group_label',
]);

$afurl->cdnAll($tags, 'img', 'thumb_hash', 'mime_id');




/////////////////////////////////////////////
// PULL THE TAGS WITHOUT THUMBNAILS
/////////////////////////////////////////////
$nttags = $db->rows([
	'gl' => 'pudl_group_label',
	'gr' => _pudl_group(50),
	'gt' => 'pudl_group_type',
], $clause+[
	'thumb_hash'			=> NULL,
	'gt.group_type_name'	=> $group,
	'gl.group_id=gr.group_id',
	'gr.group_type_id=gt.group_type_id',
], [
	'group_label',
]);




/////////////////////////////////////////////
// ALL THE LETTERS!
/////////////////////////////////////////////
$letters = array_combine(range('a', 'z'), range('A', 'Z'));
$letters['0'] = '#';
$letters['*'] = '@';




////////////////////////////////////////////////////////////////////////////////
//PROMETHEUS FORMATTING
////////////////////////////////////////////////////////////////////////////////
if ($af->prometheus()) {
	$tags += $nttags;

	foreach ($tags as &$item) {
		$item['width']	= $af->discoverWidth($item);
		$item['name']	= $item['group_label'];

		$item['url']	= $afurl([
			'tag',
			$item['group_type_name'],
			$item['group_label'],
		]);
	} unset($item);
}




/////////////////////////////////////////////
// RENDER ALL THE THINGS
/////////////////////////////////////////////
$af->header();
	$af->load($template);
		$af->block($block,		$tags);
		$af->block('nttags',	$nttags);
		$af->block('letters',	$letters);
	$af->render();
$af->footer();
