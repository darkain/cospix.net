<?php

$af->title = 'Map';
$og['description'] = 'Map of ';

require_once('../event.php.inc');


$af->scale(false);




////////////////////////////////////////////////////////////////////////////////
// PULL MAP DATA
////////////////////////////////////////////////////////////////////////////////
$hash = $afurl->cdn($event, 'thumb_hash');

if (empty($event['event_lat'])  ||  empty($event['event_lon'])) {
	$event['event_lat'] = 0;
	$event['event_lon'] = 0;
}

$render = [
	'gmap' => [
		'lat'	=> $event['event_lat'],
		'lon'	=> $event['event_lon'],
		'zoom'	=> 15
	],


	'jsmap' => [3 => ''
		. 'gmapMarker('
		. $event['event_lat'] . ',' . $event['event_lon'] . ','
		. '"' . $afurl->static . '/img/map-marker.png",'
		. '"<b>' . $af->html($event['event_venue']) . '<br />'
		. $af->html($event['event_location']) . '</b>",'
		. "'<ul class=\"cpn-map-list\"><li>"
		. '<a href="' . $afurl(['event', $event['event_name']], true) . '">'
		. '<img src="' . $hash . '" alt="' . $af->html($event['event_name']) . '">'
		. '<b>' . $af->html($event['event_name']) . '</b><br/>'
		. '<i>' . date('F jS, Y', $event['event_start']) . '</i>'
		. '</a>'
		. "</li></ul>'"
		. ");\n\n"
	],
];




////////////////////////////////////////////////////////////////////////////////
// RENDER ALL THE THINGS
////////////////////////////////////////////////////////////////////////////////
if ($af->prometheus()) {
	$afurl->jq = 'map/_index-prometheus.tpl';
} else {
	$afurl->jq = 'map/_index.tpl';
}

if ($get->int('jq')) {

	$af	->load($afurl->jq)
			->field('event',	$event)
			->MERGE($render)
		->render();

} else {
	require('_index.php');
}
