<?php

$af->title = 'Gatherings';
$og['description'] = 'Gatherings at ';

//require_once('_cospix/calendar.php.inc');
require_once('../event.php.inc');




////////////////////////////////////////////////////////////
//QUERY
////////////////////////////////////////////////////////////
$render = ['gatherings' => $db->rows(
	['gt' => _pudl_gathering(100)],
	['gt.event_id' => $event['event_id']],
	'gathering_name'
)];

$afurl->cdnAll($render['gatherings'], 'img', 'thumb_hash');




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////
$afurl->jq = 'gatherings/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq);
		$af->field('event',	$event);
		$af->block('gatherings', $render['gatherings']);
	$af->render();
} else {
	require('_index.php');
}
