<?php


$af->title = 'Teams';


require_once('../profile.php.inc');




////////////////////////////////////////////////////////////
//LOAD ALL THE CONTENTS!!
////////////////////////////////////////////////////////////
$render['team'] = $db->selectRows(
	['tm.*', 'up.*', 'us.*', 'th.thumb_hash'],
	[
		'tm' => 'pudl_team',
		'up' => 'pudl_user_profile',
		'us' => _pudl_user(100)
	],
	[
		'tm.user_id' => $profile['user_id'],
		'us.user_id=tm.team_id',
		'us.user_id=up.user_id',
	],
	'user_name'
);

$afurl->cdnAll($render['team'], 'img', 'thumb_hash');




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////
$afurl->jq = 'teams/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq);
		$af->field('user', $profile);
		$af->merge($render);
	$af->render();
} else {
	require('_index.php');
}
