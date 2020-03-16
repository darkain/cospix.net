<?php



////////////////////////////////////////////////////////////
//PULL ATTENDING EVENTS DATA
////////////////////////////////////////////////////////////
$result = $db->group(
	['ev.*', 'th.thumb_hash'],
	['ue'=>'pudl_user_event', 'ev'=>_pudl_event(50), 'te'=>'pudl_team'],
	['ev.event_id=ue.event_id',	'ue.user_id=te.user_id', 'te.team_id'=>$team['user_id']],
	'ev.event_id',
	['event_start'=>pudl::dsc()]
);

$render['eventlist'] = $result->rows();
$result->free();

$afurl->cdnAll($render['eventlist'], 'img', 'thumb_hash');

foreach ($render['eventlist'] as &$item) {
	$item['range'] = \af\time::daterange($item['event_start'], $item['event_end']);

	if ($item['event_start'] > $db->time()) {
		$days = round(($item['event_start'] - $db->time()) / AF_DAY);
		if ($days < 2) {
			$item['countdown'] = 'NOW!';
		} else {
			$item['countdown'] = $days . ' days';
		}
	}
} unset($item);




////////////////////////////////////////////////////////////
//RECENT UPDATES
////////////////////////////////////////////////////////////
$render['g'] = $db->selectRows(
	['ga.*', 'thumb_hash', 'us.*'],
	['ga' => _pudl_gallery(100), 'te'=>'pudl_team', 'us'=>'pudl_user'],
	[
		'team_id'			=> $team['user_id'],
		'thumb_hash'		=> pudl::neq(NULL),
		'ga.user_id=te.user_id',
		'ga.user_id=us.user_id',
	],
	['gallery_timestamp'	=> pudl::dsc()],
	12
);

$afurl->cdnAll($render['g'], 'img', 'thumb_hash');
