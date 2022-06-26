<?php


$profile = $db->rowId('pudl_user_profile', 'user_id', $user);

if (empty($profile['user_lat'])) return;
if (empty($profile['user_lon'])) return;


$distance = 100; //MILES


$result = $db->having([
	'*',
	pudl::raw('(acos(sin(radians(event_lat)) * sin(radians(' . $profile['user_lat'] . ')) +
	cos(radians(event_lat)) * cos(radians(' . $profile['user_lat'] . ')) *
	cos(radians(event_lon) - radians(' . $profile['user_lon'] . '))) * 6378) AS distance'),
], 'pudl_event', [
	cpnFilterCanceled(),
	'event_start'	=> pudl::gt( \af\time::from(AF_MONTH*4) ),
	'event_lat'		=> pudl::between(
		$profile['user_lat'] - ($distance/69),
		$profile['user_lat'] + ($distance/69)
	),
	'event_lon'		=> pudl::between(
		$profile['user_lon'] - $distance/abs(cos(deg2rad($profile['user_lat']))*69),
		$profile['user_lon'] + $distance/abs(cos(deg2rad($profile['user_lat']))*69)
	),
], ['distance' => pudl::lt($distance)], 'distance');

echo $db->query();
echo "\n";

$rows = $result->rows();
$result->free();

\af\dump($rows);
