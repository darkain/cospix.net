<?php


$text = $get->string('text');
//TODO: SANATIZE INPUT... VERIFY IT IS A VALID EVERYTHINGS!!


$pos = strpos($text, ',');
if ($pos === false) \af\error(422);

$venue	= trim(substr($text, 0, $pos));
$city	= trim(substr($text, $pos+1));

$db->updateId('pudl_event', [
	'event_venue'		=> $venue,
	'event_location'	=> $city,
	'event_lat'			=> NULL,
	'event_lon'			=> NULL,
], 'event_id', $event);

echo "$venue, $city";
