<?php

////////////////////////////////////////////////////////////////////////////////
// SINGLE CHARACTER - LIST ALL TAGS
////////////////////////////////////////////////////////////////////////////////
if (strlen($router->virtual[1]) === 1) {
	require('taglist.php');
	return;
}




////////////////////////////////////////////////////////////////////////////////
// GET TAG INFORMATION
////////////////////////////////////////////////////////////////////////////////
require_once('tag.php.inc');




////////////////////////////////////////////////////////////////////////////////
//BUILD MENU DATA
////////////////////////////////////////////////////////////////////////////////
switch ($group['group_type_name']) {
	case 'universe':
		$menu = [
			//NOTE: 'Admin' is intentionally NOT $profile['edit']
			'Admin'			=> $user->isStaff(),
			'Series'		=> 1,
//			'Cosplayers'	=> 1,
			'Costumes'		=> 1,
			'Photos'		=> 0,
		];
	break;


	case 'camera':
	case 'lens':
	case 'software':
		$menu = [
			//NOTE: 'Admin' is intentionally NOT $profile['edit']
			'Admin'			=> $user->isStaff(),
			'Photos'		=> 0,
			'Camera'		=> 1,
			'Lens'			=> 1,
			'Software'		=> 1,
			'Users'			=> 1,
		];

		unset($menu[ucwords($group['group_type_name'])]);
	break;


	default:
		$menu = [
			//NOTE: 'Admin' is intentionally NOT $profile['edit']
			'Admin'			=> $user->isStaff(),

			//'Products'		=> 1,
/*
			'Episodes'		=> $profile['edit']  ||  $db->clauseExists(
				['ga'=>'pudl_gallery', 'gv'=>'pudl_gallery_video'],
				['ga.gallery_id=gv.gallery_id', 'ga.group_id'=>$group['group_id']]
			),
*/
/*			'References'	=> $profile['edit']  ||  $db->clauseExists(
				['ga'=>'pudl_gallery', 'gi'=>'pudl_gallery_image'],
				['ga.gallery_id=gi.gallery_id', 'ga.group_id'=>$group['group_id']]
			),*/

			'Universe'		=> $profile['edit']  ||  $db->clauseExists(
				[
					'ge'=>'pudl_group_relate',
					'gr'=>'pudl_group',
					'gt'=>'pudl_group_type'
				], [
					'gr.group_type_id=gt.group_type_id',
					'ge.group_child=gr.group_id',
					'ge.group_parent'		=> $group['group_id'],
					'gt.group_type_name'	=> 'universe',
				]
			),

			'Series'		=> $profile['edit']  ||  $db->clauseExists(
				[
					'ge'=>'pudl_group_relate',
					'gr'=>'pudl_group',
					'gt'=>'pudl_group_type'
				], [
					'gr.group_type_id=gt.group_type_id',
					'gt.group_type_name'	=> 'series',
					[
						['ge.group_parent'	=> $group['group_id'], 'ge.group_child=gr.group_id'],
						['ge.group_child'	=> $group['group_id'], 'ge.group_parent=gr.group_id']
					],
				]
			),

			'Characters'	=> $profile['edit']  ||  $db->clauseExists(
				[
					'ge'=>'pudl_group_relate',
					'gr'=>'pudl_group',
					'gt'=>'pudl_group_type'
				], [
					'gr.group_type_id=gt.group_type_id',
					'gt.group_type_name'	=> 'character',
					[
						['ge.group_parent'	=> $group['group_id'], 'ge.group_child=gr.group_id'],
						['ge.group_child'	=> $group['group_id'], 'ge.group_parent=gr.group_id']
					],
				]
			),

			'Galleries'		=> 1,
			'Cosplayers'	=> 1,
			'Photos'		=> 0,
			//'Tutorials'
		];
	break;
}




////////////////////////////////////////////////////////////////////////////////
//BUILD NEW PROMETHEUS COVER PHOTO
////////////////////////////////////////////////////////////////////////////////
foreach ($menu as $key => $item) {
	if (!$item) continue;

	unset($dbid);

	switch ($key) {
		case 'Admin':
		case 'Universe':
		break;

		case 'Characters':
			$dbid = 'character';
		//INTENTIONALLY FALL THROUGH

		case 'Series':
			if (empty($dbid)) $dbid = strtolower($key);
			if ($dbid === $group['group_type_name']) break;

			$actions[$key] = [
				'link'	=> strtolower($key),
				'count'	=> $db->count([
					'gr' => 'pudl_group',
					'gt' => 'pudl_group_type',
					'gl' => 'pudl_group_label',
					'ge' => 'pudl_group_relate',
				], [
					[
						['ge.group_parent'	=> $group['group_id'], 'ge.group_child=gr.group_id'],
						['ge.group_child'	=> $group['group_id'], 'ge.group_parent=gr.group_id'],
					],
					'gt.group_type_name'	=> $dbid,
					'gr.group_type_id=gt.group_type_id',
					'gl.group_id=gr.group_id',
				]),
			];
		break;


		case 'Galleries':
			if ($group['group_type_name'] !== 'universe') {
				$actions[$key] = [
					'link'	=> 'galleries',
					'count'	=> $db->count([
						'gl' => 'pudl_group_label',
						'ga' => 'pudl_gallery',
						'gx' => 'pudl_gallery_label',
					], [
						'gl.group_label_id=gx.group_label_id',
						'ga.gallery_id=gx.gallery_id',
						'gl.group_id'		=> $group['group_id'],
					]),
				];
			}
		break;


		case 'Cosplayers':
			if ($group['group_type_name'] !== 'universe') {
				$actions[$key] = [
					'link'	=> 'cosplayers',
					'count'	=> $db->countGroup([
						'gl' => 'pudl_group_label',
						'ga' => 'pudl_gallery',
						'gx' => 'pudl_gallery_label',
					], [
						'gl.group_label_id=gx.group_label_id',
						'ga.gallery_id=gx.gallery_id',
						'gl.group_id'		=> $group['group_id'],
					], 'ga.user_id'),
				];
			}
		break;


		default:
			$actions[$key] = ['count' => 'X'];
	}
}




////////////////////////////////////////////////////////////////////////////////
// AMAZON PRODUCTS
////////////////////////////////////////////////////////////////////////////////
require_once('_altaform/modules/product.php');

$product	= [];
$search		= afString::unslash($group['group_label']);
$data		= NULL; //(new \af\product($af, $db))->search($search);
// NOTE: we're currently not enabling AWS products. It needs rebuilt and tested.

if (!empty($data['Items']['Item'])) {
	$products = &$data['Items']['Item'];
	shuffle($products);
	foreach ($products as &$item) {
		if (count($product) > 7) break;
		if (empty($item['DetailPageURL'])) continue;
		if (empty($item['ItemAttributes']['Title'])) continue;
		$image = afProduct::image($item);
		if (!$image) continue;

		$product[] = [
			'url'	=> $item['DetailPageURL'],
			'name'	=> $item['ItemAttributes']['Title'],
			'image'	=> $image,
		];
	} unset($item);
}





////////////////////////////////////////////////////////////////////////////////
//INCLUDE BODY CONTENT
////////////////////////////////////////////////////////////////////////////////
if (empty($group['subpage'])) {
	require_once('tag/index.php.inc');
}




////////////////////////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS
////////////////////////////////////////////////////////////////////////////////
if (empty($afurl->jq)) {
	$afurl->jq = 'tag/_index.tpl';
}

$prometheus = false;
if ($af->prometheus()  &&  !empty($block)) {
	if (!empty($render[$block])  &&  $render[$block] instanceof pudlCollection) {
		$prometheus = true;
	}
}


if (!$prometheus) {

	if ($get->int('jq')) {
		$af->load('tag/_index.tpl');
	} else {
		$af->header();
		$af->load($af->config['root'].'/profile.tpl');
	}

	$af->field('group',		$group);
	$af->field('tag',		$group);
	$af->field('profile',	$profile);
	$af->block('actions',	$actions);
	$af->block('social',	[]);
	$af->block('admin',		[]);
	$af->block('menu',		$menu);
	$af->block('afproduct',	$product);

	if (!empty($render)) $af->merge($render);

	$af->render();

} else {

	$af->header();
	$collection = $render[$block];
	unset($render[$block]);

	$af	->load('_cospix/profile_header.tpl')
		->field('profile',	$profile)
		->block('actions',	$actions)
		->block('admin',	[])
		->block('social',	[])
		->merge($render)
		->render();

	$collection->render($af);

	$af	->load('_cospix/profile_footer.tpl')
		->field('profile',	$profile)
		->merge($render)
		->render();

	$af->footer();

}


if (!$get->int('jq')) {
	$af->footer();
}
