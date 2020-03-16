<?php

require_once('_cospix/calendar.php.inc');
require_once('../event.php.inc');




////////////////////////////////////////////////////////////
//QUERY
////////////////////////////////////////////////////////////
$render = ['gathering' => $db->row([
	'gt' => _pudl_gathering(100)
], [
	'gathering_id'	=> $event['page_id'],
	'event_id'		=> $event['event_id'],
])];

$af->title = $render['gathering']['gathering_name'];
$og['description'] = $af->title . ' gathering at ';

\af\affirm(404, $render['gathering']);

$render['gathering']['description'] = afString::linkify(
	$render['gathering']['gathering_description']
);

$render['gathering']['attending']	= false;
$render['gathering']['host']		= false;

if ($user->hasAccessStaff('event', $event)) {
	$render['gathering']['host']	= true;
}




////////////////////////////////////////////////////////////
//ATTENDEES
////////////////////////////////////////////////////////////
$render['users'] = $db->rows(
	['us'=>_pudl_user(100), 'ug'=>'pudl_user_gathering'],
	[
		'us.user_id=ug.user_id',
		'ug.gathering_attending IN ("yes","host")',
		'ug.gathering_id' => $event['page_id'],
		cpnFilterBanned(),
	],
	'ug.gathering_attending'
);

$afurl->cdnAll($render['users'], 'img', 'thumb_hash');

foreach ($render['users'] as &$item) {
	if ($user->is($item)) {
		$render['gathering']['attending'] = true;

		if ($item['gathering_attending'] === 'host') {
			$render['gathering']['host'] = true;
		}

		break;
	}
}




////////////////////////////////////////////////////////////
//TAGS
////////////////////////////////////////////////////////////
$render['tags'] = $db->selectRows(
	['gl.*', 'gt.*', 'ol.*', 'th.thumb_hash'],
	[
		'gl' => 'pudl_group_label',
		'gr' => _pudl_group(50),
		'gt' => 'pudl_group_type',
		'ol' => 'pudl_object_label',
	],
	[
		'gr.group_id=gl.group_id',
		'gr.group_type_id=gt.group_type_id',
		'ol.group_label_id=gl.group_label_id',
		'ol.object_id'		=> $event['page_id'],
		'ol.object_type_id'	=> $af->type('gathering'),
	],
	'gl.group_label'
);




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////
$afurl->jq = 'gatherings/_virtual.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq);
		$af->field('event',		$event);
		$af->field('gathering',	$render['gathering']);
		$af->block('users',		$render['users']);
		$af->block('tags',		$render['tags']);
	$af->render();
} else {
	require('_index.php');
}
