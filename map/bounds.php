<?php

$bound  = $get->string('b');
$bound  = str_replace(array('(',')'), '', $bound);
$bounds = explode(',', $bound);
if (count($bounds) < 4) $afurl->redirect("$afurl->base/map");


foreach ($bounds as $key => &$val) {
	$val = (float) $val;
} unset($val);


//FIXES ISSUES WITH INTERNATIONAL DATE LINE!!
if ($bounds[1] > $bounds[3]) {
	$clause = [
		'event_lat'		=> pudl::between($bounds[0], $bounds[2]),
		['event_lon'	=> pudl::gt($bounds[1]), 'ev.event_lon' => pudl::lt($bounds[3])],
		'event_start'	=> pudl::between($db->time()-10368000, $db->time()+31536000),
		cpnFilterCanceled(),
	];
} else {
	$clause = [
		'event_lat'		=> pudl::between($bounds[0], $bounds[2]),
		'event_lon'		=> pudl::between($bounds[1], $bounds[3]),
		'event_start'	=> pudl::between($db->time()-10368000, $db->time()+31536000),
		cpnFilterCanceled(),
	];
}



$result = $db->group(
	[
		'sort'			=> pudl::count(),
		'id'			=> 'ev.event_id',
		'value'			=> 'ev.event_name',
		'location'		=> 'ev.event_location',
		'ev.event_start',
		'ev.event_end',
		'attend'		=> 'ue.user_id',
		'url'			=> pudl::text('event'),
		'th.thumb_hash',
	],
	['ev' => array_merge(_pudl_event(50), [
		[
			'left'=>['ue'=>'pudl_user_event'],
			'on'=>['ue.event_id=ev.event_id', 'ue.user_id'=>$user['user_id']]
		],
		['left'=>['ex'=>'pudl_user_event'], 'on'=>'ex.event_id=ev.event_id']
	])],
	$clause,
	'ev.event_id',
	[
		'attend'	=> pudl::dsc(),
		'sort'		=> pudl::dsc(),
		'ev.event_name',
	],
	50
);

$data = $result->rows();
$result->free();

foreach ($data as $key => &$val) {
	if ($val['event_start'] > $db->time()) {
		$days = round(($val['event_start'] - $db->time()) / AF_DAY);
		if ($days < 2) {
			$val['countdown'] = 'NOW!';
		} else {
			$val['countdown'] = $days . ' days';
		}
	}

	$val['img']		= $afurl->cdn($val, 'thumb_hash');
	$val['date']	= \af\time::daterange($val['event_start'], $val['event_end']);
} unset($val);


$af->renderBlock('bounds.tpl', 'b', $data);
