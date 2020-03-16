<?php

require_once('../profile.php.inc');


$afurl->jq	= 'galleries/_prometheus.tpl';
$block		= 'item';




////////////////////////////////////////////////////////////////////////////////
//IS THIS AN IMAGE INSIDE OF THE GALLERY?
////////////////////////////////////////////////////////////////////////////////
if (strlen($router->part[5]) > 30  &&  ctype_xdigit($router->part[5])) {
	$_GET['gallery'] = $router->virtual[2];
	$profile->noheader = true;
	//require('_index.php');
	return $router->reparse(['image', $router->part[5]]);
}




////////////////////////////////////////////////////////////////////////////////
//LOAD ALL THE CONTENTS!!
////////////////////////////////////////////////////////////////////////////////
$render['gallery'] = $db->selectRow(
	[
		'us.*', 'ga.*', 'th.*', 'ev.*', 'gt.*',
	], [
		'us' => 'pudl_user',
		'ga' => _pudl_gallery(200)+[
			['left'=>['ev'=>'pudl_event'], 'on'=>'ga.event_id=ev.event_id'],
			['left'=>['gt'=>'pudl_gathering'], 'on'=>'ga.gathering_id=gt.gathering_id'],
		]
	], [
		'gallery_id' => $profile['page_id'],
		'ga.user_id=us.user_id',
		cpnFilterBanned()
	]
);




////////////////////////////////////////////////////////////////////////////////
//CHECK IF THIS IS AN OLD STYLE URL, THEN REDIRECT TO NEW STYLE!
////////////////////////////////////////////////////////////////////////////////
if (empty($render['gallery'])) {
	$item = $db->row(
		['co'=>'pudl_costume', 'us'=>'pudl_user'],
		['costume_id'=>$profile['page_id'], 'co.user_id=us.user_id']
	);

	if (!empty($item)) {
		$afurl->redirect([$profile, 'gallery', $item['gallery_id']]);
	}
	\af\error(404);
}




////////////////////////////////////////////////////////////////////////////////
//VERIFY USER OWNS GALLERY
////////////////////////////////////////////////////////////////////////////////
\af\affirm(404, $profile->is($render['gallery']));




////////////////////////////////////////////////////////////////////////////////
//IF WE'RE NOT IN THE RIGHT TYPE OF URL, THEN REDIRECT!
////////////////////////////////////////////////////////////////////////////////
if ($render['gallery']['gallery_type'] !== 'gallery') {
	if (!$af->prometheus()) {
		$afurl->redirect([
			$profile,
			$render['gallery']['gallery_type'],
			$profile['page_id']
		]);
	}
}




////////////////////////////////////////////////////////////////////////////////
//VIEW COUNTER
////////////////////////////////////////////////////////////////////////////////
$redis = $db->redis();
if ($redis instanceof Redis  &&  !\af\device::bot()) {
	try {
		$key	= 'cpn:gallery:' . $render['gallery']['gallery_id'] . ':view:';
		$key	.= $user->loggedIn() ? $user['user_id'] : \af\ip::address();
		$count	= $redis->get($key);
		if ($count === false) {
			$redis->set($key, 1, AF_HOUR);
			$render['gallery']['gallery_views']++;

//			$db->begin();
				$db->incrementId(
					'pudl_gallery',
					'gallery_views',
					'gallery_id',
					$render['gallery']
				);

				$db->insert('pudl_pageview', [
					'object_id'			=> $render['gallery']['gallery_id'],
					'object_type_id'	=> $af->type('gallery'),
					'view_timestamp'	=> $db->time(),
					'user_id'			=> $user['user_id'],
					'user_ip'			=> \af\ip::address(),
				]);
//			$db->commit();
		}
	} catch (Exception $e) {}
}




////////////////////////////////////////////////////////////////////////////////
//PROCESS THINGS!
////////////////////////////////////////////////////////////////////////////////
$render['gallery']['img']	= $afurl->cdn($render['gallery'], 'thumb_hash');
$render['gallery']['text']	= afString::linkify($render['gallery']['gallery_notes']);
$render['gallery']['role']	= cpn_role($render['gallery']['gallery_role']);

$render['gallery']['gallery_updated'] = \af\time::since($render['gallery']['gallery_timestamp']);




////////////////////////////////////////////////////////////////////////////////
// GALLERY ITEMS - IMAGE THUMBNAILES
////////////////////////////////////////////////////////////////////////////////
$render[$block] = cpn_photo::collect($db, [
	'column'	=> ['gi.*'],

	'table'		=> ['gi' => 'pudl_gallery_image'],

	'clause'	=> [
		'gi.file_hash=fl.file_hash',
		'gi.gallery_id'	=> $profile->page_id,
	],

	'order'		=> [
		'image_sort'	=> pudl::asc(),
		'image_time'	=> pudl::desc(),
	],
]);

$render[$block]->_extend($profile, ['user_id', 'user_url']);




////////////////////////////////////////////////////////////////////////////////
// SERIES TAGS
////////////////////////////////////////////////////////////////////////////////
foreach (['series', 'character', 'outfit'] as $tagname) {
	$render[$tagname] = $db->rows([
		'xl' => 'pudl_gallery_label',
		'gl' => 'pudl_group_label',
		'gr' => 'pudl_group',
		'gt' => 'pudl_group_type',
	], [
		'xl.group_label_id=gl.group_label_id',
		'gl.group_id=gr.group_id',
		'gr.group_type_id=gt.group_type_id',
		'gt.group_type_name'	=> $tagname,
		'xl.gallery_id'			=> $render['gallery']['gallery_id'],
	]);
}




////////////////////////////////////////////////////////////////////////////////
// PHOTO UPLOADER AND PAGE HEADER
////////////////////////////////////////////////////////////////////////////////
if ($af->prometheus()) {
	if ($user->is($render['gallery'])) {
		$render[$block]->data('sort', $afurl(['gallery', 'sort', $render['gallery']['gallery_id']], true));

		$render[$block]->unshift(new cpn_custom($db, 'gallery/add.tpl'));

		$render[$block]->unshift(new cpn_custom($db, 'gallery/sort.tpl', [
			'gallery_id' => $render['gallery']['gallery_id'],
		]));
	}

	$render[$block]->header = [
		'template'		=> [
			'gallery/header.tpl',
			'gallery/scripts.tpl',
			'gallery/p_header.tpl',
		],
		'profile'	=> $profile,
		'gallery'	=> $render['gallery'],
		'series'	=> $render['series'],
		'character'	=> $render['character'],
		'outfit'	=> $render['outfit'],
	];

	$render[$block]->footer = [
		'template'	=> 'gallery/p_footer.tpl',
		'profile'	=> $profile,
		'gallery'	=> $render['gallery'],
	];
}




////////////////////////////////////////////////////////////////////////////////
// OPEN GRAPH, TWITTER CARD, MICRO DATA
////////////////////////////////////////////////////////////////////////////////
$af->title = $render['gallery']['gallery_name'];
$og['image'] = $render['gallery']['img'];

$og['description'] = afString::truncateword(
	$render['gallery']['gallery_name'] . ' ' .
	$render['gallery']['gallery_type'] . ' by ' .
	$render['gallery']['user_name'] . ' on Cospix.net - ' .
	$render['gallery']['gallery_notes'],
	1000
);

$af->metas([
	['name'=>'twitter:card',		'content'=>'gallery'],
	['name'=>'twitter:site',		'content'=>'@cospixnet'],
	['name'=>'twitter:domain',		'content'=>'Cospix.net'],
	['name'=>'twitter:title',		'content'=>$af->title . ' - ' . $og['title']],
	['name'=>'twitter:description',	'content'=>$og['description']],
]);

$x = 0;
foreach ($render[$block] as $item) {
	$af->meta(['name'=>"twitter:image$x", 'content'=>$item['img']]);
	$af->meta(['property'=>"og:image", 'content'=>$item['img']]);
	if ($x++ == 3) break;
} unset($item);




////////////////////////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////////////////////////
if ($get->int('jq')) {
	$af->load($afurl->jq);
		$af->field('user', $profile);
		$af->merge($render);
	$af->render();
} else {
	require('_index.php');
}
