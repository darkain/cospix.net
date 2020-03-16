<?php


$result = $db->select(
	['us.*', 'ct.*', 'th.thumb_hash'],
	[
		'us' => _pudl_user(50),
		'up' => 'pudl_user_profile',
		'ct' => 'pudl_city',
	],
	[
		'us.user_id=up.user_id',
		'up.user_city=ct.city_id',
		cpnFilterBanned(),
	]
);

$map = '';
while ($val = $result->row()) {
	$hash = $afurl->cdn($val, 'thumb_hash');
	if (empty($hash)) $hash = "$afurl->static/thumb2/profile.svg";

	$userurl = empty($val['user_url']) ? $val['user_id'] : $val['user_url'];

	$map .= 'gmapMarker(';

	$map .= $val['city_lat'] . ',' . $val['city_lon'] . ',';

	$map .= '"' . $afurl->static . '/img/map-marker.png",';

	$map .= '"<b>' . htmlspecialchars($val['city_accent'], ENT_QUOTES) . '</b>",';

	$map .= "'<ul class=\"cpn-map-list\"><li>";

	$map .= '<a href="' . $afurl->base . '/' . $userurl . '">';
	$map .= '<img src="' . $hash . '" alt="' . htmlspecialchars($val['user_name'], ENT_QUOTES) . '">';

	$map .= '<strong>' . htmlspecialchars($val['user_name'], ENT_QUOTES) . '</strong>';
	//$map .= '<em>' . date('F jS, Y', $val['event_start']) . '</em>';
	$map .= '</a>';

	$map .= "</li></ul>'";

	$map .= ");\n";
}

$result->free();


$af->header();
	$af->load('_index.tpl');
		$af->field('gmap',	$geo->center($user, $get));
		$af->field('map',	$map);
	$af->render();
$af->footer();
