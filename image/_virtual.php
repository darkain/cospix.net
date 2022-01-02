<?php

//SITEMAP, NOT AN IMAGE
if (strpos($router->virtual[0], 'sitemap.list') === 0) {
	require('sitemap.list.xml.php');
	return;
} else if (strpos($router->virtual[0], 'sitemap.item') === 0) {
	require('sitemap.item.xml.php');
	return;
}




require_once('pretty.php.inc');




////////////////////////////////////////////////////////////////////////////////
// INITIALIZE THINGS!
////////////////////////////////////////////////////////////////////////////////
$hash		= $router->virtual[0];
$filehash	= pudl::unhex($hash);
$discover	= [];




////////////////////////////////////////////////////////////////////////////////
// PULL IMAGE DATA
////////////////////////////////////////////////////////////////////////////////
$image = $db->selectRow(
	['th.*', 'fl.*', 'JSON_file_meta_value'=>pudl::column_json(pudl::column('fm.file_meta_value'))],
	['fl' => _pudl_file( \af\device::tablet() ? 800 : 1920 ) + [
		['left'=>['fm'=>'pudl_file_meta'], 'on'=>[
			'fl.file_hash=fm.file_hash',
			pudl::column_check(pudl::column('file_meta_value')),
		]],
	]],
	['fl.file_hash' => $filehash]
);
\af\affirm(404, $image);

$image['gallery_id']	= $get->id('gallery');
$image['hash']			= bin2hex($image['file_hash']);
$image['cdn']			= $afurl->cdn($image, 'file_hash',	'mime_id');
$image['url']			= $afurl->cdn($image, 'thumb_hash',	'mime_id');

if (empty($image['url'])) {
	$image['url']		= $afurl->cdn($image, 'file_hash',	'mime_id');
}




////////////////////////////////////////////////////////////////////////////////
// IS IT A FAVORITE?
////////////////////////////////////////////////////////////////////////////////
if ($user->loggedIn()) {
	$image['favorite'] = (int) $db->clauseExists('pudl_favorite', [
		'user_id'	=> $user['user_id'],
		'file_hash'	=> $image['file_hash'],
	]);
}




////////////////////////////////////////////////////////////////////////////////
// IS IT A FEATURED IMAGE?
////////////////////////////////////////////////////////////////////////////////
$image['featured'] = $db->rowId('pudl_feature', 'file_hash', $image);




////////////////////////////////////////////////////////////////////////////////
// IMAGE EXIF / META DATA
////////////////////////////////////////////////////////////////////////////////
//$image['meta'] = @json_decode($image['file_meta_value'], true);
//$image['meta'] = pudl::jsonDecode($image['file_meta_value']);
$image['meta'] = &$image['file_meta_value'];
prettyExif($image['meta']);

if (!empty($image['thumb_type'])  &&
	!empty($image['meta']['COMPUTED']['Width'])  &&
	!empty($image['meta']['COMPUTED']['Height'])) {

	switch (isset($image['meta']['Orientation']) ? $image['meta']['Orientation'] : 1) {
		case 5:
		case 6:
		case 7:
		case 8:
			$image['height']	= $image['meta']['COMPUTED']['Width'];
			$image['width']		= $image['meta']['COMPUTED']['Height'];
		break;

		default:
			$image['width']		= $image['meta']['COMPUTED']['Width'];
			$image['height']	= $image['meta']['COMPUTED']['Height'];
	}

	if ($image['width'] > $image['height']) {
		$image['ratio'] = $image['height'] / $image['width'];
		$image['width'] = $image['thumb_type'];
		$image['height'] = (int) ($image['width'] * $image['ratio']);
		$image['size'] = "width:$image[width]px;height:$image[height]px;";
	} else {
		$image['ratio'] = $image['width'] / $image['height'];
		$image['height'] = $image['thumb_type'];
		$image['width'] = (int) ($image['height'] * $image['ratio']);
		$image['size'] = "width:$image[width]px;height:$image[height]px;";
	}
}




////////////////////////////////////////////////////////////////////////////////
// OPEN GRAPH DATA - FACEBOOK / TWITTER
////////////////////////////////////////////////////////////////////////////////
$af->title = '';

$og['image']		= 'https:'.$image['url'];
$og['keywords']		= 'cosplay, photo, gallery';
$og['description']	= 'Cospix.net photo';

$af->metas([
	['name'=>'twitter:card',		'content'=>'photo'],
	['name'=>'twitter:site',		'content'=>$og['twittername']],
	['name'=>'twitter:domain',		'content'=>$og['twitterdomain']],
	['name'=>'twitter:title',		'content'=>&$af->title],
	['name'=>'twitter:image',		'content'=>$og['image']],
	['name'=>'twitter:description',	'content'=>&$og['description']],
]);




////////////////////////////////////////////////////////////////////////////////
//VIEW COUNTER
////////////////////////////////////////////////////////////////////////////////
$redis = $db->redis();
if (!empty($image['gallery_id'])  &&  $redis instanceof Redis  &&  !\af\device::bot()) {
	try {
		$key	= 'cpn:image:' . $hash . ':view:';
		$key	.= $user->loggedIn() ? $user['user_id'] : \af\ip::address();
		$count	= $redis->get($key);
		if ($count === false) {
			$redis->set($key, 1, AF_HOUR);
			$image['file_views']++;

//			$db->begin();
				$db->incrementId(
					'pudl_file',
					'file_views',
					'file_hash',
					pudl::unhex($image['hash'])
				);

				$db->insert('pudl_pageview', [
					'file_hash'			=> $filehash,
					'object_id'			=> $image['gallery_id'],
					'object_type_id'	=> $af->type('image'),
					'view_timestamp'	=> $db->time(),
					'user_id'			=> $user['user_id'],
					'user_ip'			=> \af\ip::address(),
				]);
//			$db->commit();
		}
	} catch (Exception $e) {}
}




////////////////////////////////////////////////////////////////////////////////
// TEXT DESCRIPTIONS FOR EVERY OWNER
////////////////////////////////////////////////////////////////////////////////
/*
$texts = $db->rows(
	array(
		'fu'=>'pudl_file_user',
		'us'=>'pudl_user'
	),
	array(
		'file_hash'=>pudl::unhex($hash),
		'us.user_id=fu.user_id',
		cpnFilterBanned(),
	)
);
*/




////////////////////////////////////////////////////////////////////////////////
// GALLERIES
////////////////////////////////////////////////////////////////////////////////
$result = $db->select(
	[
		'us.*',
		'ga.*',
		'th.thumb_hash'
	], [
		'ga' => _pudl_gallery(),
		'us' => 'pudl_user',
		'gi' => 'pudl_gallery_image',
	], [
		'us.user_id=ga.user_id',
		'gi.file_hash' => $filehash,
		'gi.gallery_id=ga.gallery_id',
		cpnFilterBanned(),
	],
	'gallery_role'
);


$image['owner']	= 0;
$set			= [];
$owners			= [];
$galleries		= [];

while ($item = $result()) {
	if ($user->is($item)) $image['owner'] = 1;

	$owners[]		= $item['user_id'];
	$galleries[]	= $item['gallery_id'];

	if (!in_array($item['user_name'], $set)) {
		$set[] = $item['user_name'];
		$og['keywords'] .= ', ' . $item['user_name'];
	}

	switch ($item['gallery_role']) {
		case 'photo':		$item['role'] = 'Photographer';		break;
		case 'cosplay':		$item['role'] = 'Cosplayer';		break;
		case 'seamstress':	$item['role'] = 'Seamstress';		break;
		case 'wig':			$item['role'] = 'Wig/Hair Stylist';	break;
		case 'mua':			$item['role'] = 'Makeup Artist';	break;
		case 'prop':		$item['role'] = 'Prop Maker';		break;
		case 'accessory':	$item['role'] = 'Accessories';		break;
		case 'post':		$item['role'] = 'Post Production';	break;
		case 'assistant':	$item['role'] = 'Assistant';		break;
		default:			$item['role'] = '';
	}

	$discover[] = $item + [
		'type'		=> $item['gallery_type'],
		'name'		=> $item['gallery_name'],
		'img'		=> $afurl->cdn($item),
		'url'		=> $afurl->user($item, $item['gallery_type'], $item['gallery_id']),
		'icon'		=> $item['gallery_type'].'.svg',
	];
}

if (!empty($set)) {
	$og['description'] .= ' featuring ' . afString::implode($set);
}




////////////////////////////////////////////////////////////////////////////////
// CREDITS
////////////////////////////////////////////////////////////////////////////////
$result = $db->select(
	'*',
	[
		'us' => _pudl_user(),
		'fu' => 'pudl_file_user',
	], [
		'us.user_id=fu.user_id',
		'fu.file_user_visible=1',
		'us.user_id'	=> pudl::neq($owners),
		'fu.file_hash'	=> $filehash,
		cpnFilterBanned(),
	]
);

while ($item = $result()) {
	$discover[] = $item + [
		'type'		=> 'profile',
		'name'		=> 'Credited',
		'img'		=> $afurl->cdn($item),
		'url'		=> $afurl->user($item),
		'icon'		=> 'profile.svg',
	];
}




////////////////////////////////////////////////////////////////////////////////
// CONVENTION
////////////////////////////////////////////////////////////////////////////////
$result = $db->group(
	[
		'id' => 'ev.event_id',
		'ev.event_name',
		'ev.event_start',
		'ev.event_end',
		'th.thumb_hash',
	], [
		'gi' => 'pudl_gallery_image',
		'ga' => 'pudl_gallery',
		'ev' => _pudl_event(),
	], [
		'gi.file_hash' => $filehash,
		'gi.gallery_id=ga.gallery_id',
		'ga.event_id=ev.event_id',
	],
	'ev.event_id',
	'ev.event_name'
);


while ($item = $result()) {
	$discover[] = $item + [
		'type'		=> 'event',
		'name'		=> $item['event_name'],
		'img'		=> $afurl->cdn($item),
		'url'		=> 'event/' . $afurl->clean($item['event_name']),
		'icon'		=> 'convention.svg',
	];
}




////////////////////////////////////////////////////////////////////////////////
// LINKED TUTORIALS
////////////////////////////////////////////////////////////////////////////////
if (!empty($galleries)) {
	$result = $db->group(
		[
			'ar.*',
			'th.thumb_hash',
		], [
			'gt' => 'pudl_gallery_tutorial',
			'ar' => _pudl_article(),
		], [
			'ar.article_id=gt.article_id',
			'gt.gallery_id' => $galleries,
		]
	);

	while ($item = $result()) {
		$discover[] = $item + [
			'type'		=> 'tutorial',
			'name'		=> $item['article_title'],
			'img'		=> $afurl->cdn($item),
			'url'		=> 'tutorial/' . $item['article_id'],
			'icon'		=> 'tutorial.svg',
		];
	}
}




////////////////////////////////////////////////////////////////////////////////
// GALLERY TAGS
////////////////////////////////////////////////////////////////////////////////
$result = cpnTag::getFileImage($filehash);
while ($item = $result()) {
	$item['type']		= 'tag';
	$item['typename']	= $item['group_type_name'];
	$item['name']		= $item['group_label'];
	$item['img']		= $afurl->cdn($item);
	$item['icon']		= $item['typename'].'.svg';

	$item['url']		= $item['type']	. '/' . $afurl->clean($item['typename'])
										. '/' . $afurl->clean($item['name']);

	$discover[] = $item;
}




////////////////////////////////////////////////////////////////////////////////
// OWNER
////////////////////////////////////////////////////////////////////////////////
$owner = $db->row(
	[
		'fu' => 'pudl_file_user',
		'gi' => 'pudl_gallery_image',
		'ga' => [
			'pudl_gallery',
			['left'=>['us'=>'pudl_user'], 'using'=>'user_id'],
			['left'=>['gr'=>'pudl_group'], 'using'=>'group_id'],
			['left'=>['gl'=>'pudl_group_label'], 'using'=>'group_id'],
		]
	],
	[
		'fu.file_hash=gi.file_hash',
		'fu.user_id=ga.user_id',
		'ga.gallery_id=gi.gallery_id',
		'ga.gallery_id'	=> $image['gallery_id'],
		'gi.file_hash'	=> $filehash,
		cpnFilterBanned(),
	]
);

if (!empty($owner['gallery_name'])) {
	$af->title .= $owner['gallery_name'];
}

if (!empty($owner['user_name'])) {
	if (!empty($af->title)) $af->title .= ' by ';
	$af->title .= $owner['user_name'];
} else if (!empty($owner['group_label'])) {
	if (!empty($af->title)) $af->title .= ' - ';
	$af->title .= $owner['group_label'];
}

if (!empty($owner['file_text'])) {
	$image['text'] = afString::linkify($owner['file_text']);
	$image['file_text'] = $owner['file_text'];
} else {
	$image['text'] = $image['file_text'] = '';
}




////////////////////////////////////////////////////////////////////////////////
// OTHER IMAGES IN SAME GALLERY
////////////////////////////////////////////////////////////////////////////////
if (empty($owner)) {
	$thumbs = [];
} else {
	$thumbs_left = array_reverse($db->selectRows([
			'th.*',
			'gi.*',
			'us.user_id',
			'us.user_url',
		], [
			'gi' => _pudl_gallery_image(100),
			'ga' => 'pudl_gallery',
			'us' => 'pudl_user',
		], [
			'ga.gallery_id'	=> $image['gallery_id'],
			'image_sort'	=> pudl::lteq($owner['image_sort']),
			'gi.gallery_id=ga.gallery_id',
			'ga.user_id=us.user_id',
		], [
			'image_sort'=>pudl::dsc(),
			'image_time'
		],
		9
	));

	$thumbs_right = $db->selectRows([
			'th.*',
			'gi.*',
			'us.user_id',
			'us.user_url',
		], [
			'gi' => _pudl_gallery_image(100),
			'ga' => 'pudl_gallery',
			'us' => 'pudl_user',
		], [
			'ga.gallery_id'	=> $image['gallery_id'],
			'image_sort'	=> pudl::gt($owner['image_sort']),
			'gi.gallery_id=ga.gallery_id',
			'ga.user_id=us.user_id',
		], [
			'image_sort',
			'image_time'=>pudl::dsc()
		],
		9
	);

	$x = count($thumbs_left) - 2;
	$image['prev'] = empty($thumbs_left[$x]) ? null : bin2hex($thumbs_left[$x]['file_hash']);
	$image['next'] = empty($thumbs_right[0]) ? null : bin2hex($thumbs_right[0]['file_hash']);

	while (count($thumbs_left)+count($thumbs_right) > 9) {
		if (count($thumbs_left) > count($thumbs_right)) {
			array_shift($thumbs_left);
		} else {
			array_pop($thumbs_right);
		}
	}

	$thumbs = array_merge($thumbs_left, $thumbs_right);

	foreach ($thumbs as &$item) {
		$item['hash'] = bin2hex($item['file_hash']);
		$item['path'] = $afurl->user($item);
	} unset($item);

	$afurl->cdnAll($thumbs, 'img', 'thumb_hash');
}




////////////////////////////////////////////////////////////////////////////////
// COMMENTS
////////////////////////////////////////////////////////////////////////////////
$comments = $db->rows(
	['us'=>_pudl_user(50), 'cm'=>'pudl_comment'],
	[
		'cm.commenter_id=us.user_id',
		'cm.file_hash'		=> $filehash,
		'cm.object_type_id'	=> $af->type('image'),
		cpnFilterBanned(),
	],
	'comment_timestamp'
);

//TODO: this is temporary to figure out why the hell this is bugging out
\af\affirm(500, is_array($comments), print_r($comments,true));

foreach ($comments as &$item) {
	$item['timesince'] = \af\time::since( $item['comment_timestamp'] );
} unset($item);
$afurl->cdnAll($comments, 'img', 'thumb_hash');

$newcomment = ['type'=>'image', 'id'=>$hash];




////////////////////////////////////////////////////////////////////////////////
// RENDER CONTENT
////////////////////////////////////////////////////////////////////////////////
$afurl->jq = '_virtual-prometheus.tpl';

$af->header();
	$af->load($afurl->jq);
		$af->field('image',		$image);
		$af->field('exif',		$image['meta']);
		$af->field('newcomm',	$newcomment);
		$af->field('owner',		$owner);
		$af->block('comment',	$comments);
		$af->block('thumbs',	$thumbs);
		$af->block('item',		$discover);
	$af->render();
$af->footer();
