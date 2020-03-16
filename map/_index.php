<?php


$af->title = 'Conventions';
$og['description'] = 'Event Map for Anime, Gaming, Comic, Sci-Fi and other conventions around the world';
//$og['viewport'] = 'width=1000,user-scalable=no';




/////////////////////////////////////////////
// PULL CACHED DATA
/////////////////////////////////////////////
try {
	$map = $db->redis()->get('cpn:map');
} catch (Exception $e) {
	$map = false;
}




/////////////////////////////////////////////
// IF NO CACHE, PULL FROM DATABASE
/////////////////////////////////////////////
if (empty($map)) {
	$result = $db->select(
		[
			'event_id',			'event_name',		'event_location',
			'event_venue',		'event_lat',		'event_lon',
			'event_start',		'event_end',
			'th.file_hash',		'th.thumb_hash',	'tx.mime_id',
		],
		['ev' => _pudl_event(200)],
		[
			'event_lat'		=> pudl::neq(NULL),
			'event_lon'		=> pudl::neq(NULL),
			'event_start'	=> pudl::between($db->time()-(AF_MONTH*4), $db->time()+AF_YEAR),
			cpnFilterCanceled(),
		],
		['ev.event_start', 'ev.event_end', 'ev.event_id']
	);


	$map = '';
	while ($val = $result->row()) {
		$hash = $afurl->cdn($val, 'thumb_hash', 'mime_id');
		$map .= 'gmapMarker(';

		$map .= $val['event_lat'] . ',' . $val['event_lon'] . ',';

		$map .= '"' . $afurl->static . '/img/map-marker.png",';

		$map .= '"<b>' . htmlspecialchars($val['event_venue'], ENT_QUOTES) . '<br />';
		$map .= htmlspecialchars($val['event_location'], ENT_QUOTES) . '</b>",';

		$map .= "'<ul class=\"cpn-map-list\"><li>";

		$map .= '<a href="' . $afurl->base . '/event/' . $afurl->clean($val['event_name']) . '">';
		$map .= '<img src="' . $hash . '" alt="' . htmlspecialchars($val['event_name'], ENT_QUOTES) . '">';

		if ($val['event_start'] > $db->time()) {
			$days = round(($val['event_start'] - $db->time()) / AF_DAY);
			if ($days < 2) {
				$map .= '<span>NOW!</span>';
			} else {
				$map .= "<span>$days days</span>";
			}
		}

		$map .= '<strong>' . htmlspecialchars($val['event_name'], ENT_QUOTES) . '</strong>';
		$map .= '<em>' . \af\time::daterange($val['event_start'], $val['event_end']) . '</em>';
		$map .= '</a>';

		$map .= "</li></ul>'";

		$map .= ");\n";
	}

	$result->free();


	try {
		$db->redis()->set('cpn:map', $map, AF_HOUR);
	} catch (Exception $e) {}
}




/////////////////////////////////////////////
// RENDER ALL THE THINGS
/////////////////////////////////////////////
$af	->header()
		->load('_index.tpl')
			->field('gmap',	$geo->center($user, $get))
			->field('map',	$map)
		->render()
	->footers('footer', 0)
	->footer();
