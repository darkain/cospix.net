<?php

$name = $get->string('name');
$loc  = $get->string('loc');

if (empty($name)) \af\error(422);

$name = str_ireplace("\\n", ' ', $name);
$name = str_ireplace("\\r", ' ', $name);
$name = preg_replace('/\s+/', ' ', $name);


$row = $db->rowId('pudl_geolocation', 'location', $name);
if (empty($row)) {
	if (empty($loc)) \af\error(422);

	$loc = str_replace('(',  '',  $loc);
	$loc = str_replace(')',  '',  $loc);

	$locs = explode(',', $loc);
	if (count($locs) !== 2) \af\error(404);
	$locs[0] = (float)$locs[0];
	$locs[1] = (float)$locs[1];

	$db->insert('pudl_geolocation', [
		'location'	=> $name,
		'lat'		=> $locs[0],
		'lon'		=> $locs[1],
	], true);
} else {
	$locs = [$row['lat'], $row['lon']];
}

$db->updateId('pudl_event', [
	'event_lat' => $locs[0],
	'event_lon' => $locs[1]
],	'event_id', $router->id);

$db->purge('cpn:map');

echo "($locs[0], $locs[1])";
