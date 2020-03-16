<?php

$bound  = $get->string('b');
$bound  = str_replace(array('(',')'), '', $bound);
$bounds = explode(',', $bound);
if (count($bounds) < 4) $afurl->redirect("$afurl->base/profile/map");


//FIXES ISSUES WITH INTERNATIONAL DATE LINE!!
if ($bounds[1] > $bounds[3]) {
	$clause = [
		'us.user_lat'=>pudl::between($bounds[0], $bounds[2]),
		['us.user_lon'=>pudl::gteq($bounds[1]), 'user_lon'=>pudl::lteq($bounds[3])],
	];
} else {
	$clause = [
		'us.user_lat'=>pudl::between($bounds[0], $bounds[2]),
		'us.user_lon'=>pudl::between($bounds[1], $bounds[3]),
	];
}



$result = $db->group(
	[
		'sort'				=> pudl::count(),
		'id'				=> 'us.user_id',
		'value'				=> 'us.user_name',
		'location'			=> 'us.user_location',
		'th.file_hash',
		'url'				=> pudl::text('profile'),
	],
	[
		'us' => ['pudl_user',
			[
				'left'		=> ['th' => 'pudl_file'],
				'clause'	=> 'us.user_icon=th.file_parent'
			],
			[
				'left'		=> ['ue' => 'pudl_user_event'],
				'clause' 	> 'us.user_id=ue.user_id'
			],
		],
	],
	array_merge($clause, [
		pudl::find('user_service', ['photography','videography']),
		cpnFilterBanned(),
	]),
	[
		'us.user_id',
	],
	[
		'sort'=>pudl::dsc(),
		'us.user_id',
	],
	20
);

$data = $result->rows();
$result->free();

foreach ($data as $key => &$val) {
	$val['img']  = $afurl->cdn($val);
//	$val['date'] = date('F jS, Y', $val['date']);
} unset($val);


$af->renderBlock('map/bounds.tpl', 'b', $data);
