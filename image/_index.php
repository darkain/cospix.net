<?php
//$afurl->redirect("$afurl->base/");
//exit;

$user->requireLogin();

$af->title = 'Credited Images';


$offset = $get->int('from');
$clause = empty($offset) ? [] : ['user_time'=>pudl::lt($offset)];




////////////////////////////////////////////////////////////
//PULL CREDITED IMAGE DATA
////////////////////////////////////////////////////////////
$result = $db->group(
	[
		'fu.*',
		'fl.*',
		'th.*',
		'count'	=> pudl::count('gi.file_hash'),
		'hash'	=> pudl::hex(pudl::column('fl.file_hash')),
	],
	[
		'fu' => 'pudl_file_user',
		'fl' => array_merge(_pudl_file(100), [
			[
				'left'	=> ['gi' => 'pudl_gallery_image'],
				'on'	=> ['gi.file_hash=fl.file_hash']
			]
		])
	],
	array_merge($clause, [
		'user_id'=>$user['user_id'],
		'fu.file_hash=fl.file_hash',
	]),
	'fl.file_hash',
	['user_time'=>pudl::dsc()],
	41
);

$photos = $result->rows();
$result->free();

$more = ['more' => isset($photos[40]) ? 1 : 0];
unset($photos[40]);

$afurl->cdnAll($photos, 'img', 'thumb_hash');




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////
if ($get->int('jq')) {
	$af->load('list.tpl');
		$af->block('photo',	$photos);
	$af->render();
} else {
	$af->header();
		$af->load('_index.tpl');
			$af->field('more',	$more);
			$af->block('photo',	$photos);
		$af->render();
	$af->footer();
}
