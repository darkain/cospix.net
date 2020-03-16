<?php

$af->title = 'Attendees';
$og['description'] = 'Attendees as ';

require_once('../event.php.inc');



if ($af->prometheus()) {
	$block	= 'item';
} else {
	$block	= 'users';
}




////////////////////////////////////////////////////////////////////////////////
//PULL USER DATA
////////////////////////////////////////////////////////////////////////////////
$render[$block] = cpn_user::collect($db, [
	'table'		=> ['ue' => 'pudl_user_event'],
	'clause'	=> [
		cpnFilterUserType(),
		'us.user_id=ue.user_id',
		'event_id' => $event['event_id'],
	],
	'order'		=> ['user_name' => pudl::asc()],
//	'limit'		=> 101,
]);




////////////////////////////////////////////////////////////////////////////////
//PROCESS ITEMS
////////////////////////////////////////////////////////////////////////////////
$render[$block]->header = ['template'=>'attendees/header.tpl'];

foreach ($render[$block] as $item) {
	if ($af->prometheus()) {
		$item->name = $item->user_tagline;
	} else {
		$item->name = str_replace(',', ', ', $item['user_type']);
	}
	$item->following = false;
};




////////////////////////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////////////////////////
$afurl->jq = 'attendees/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq);
		$af->field('event',	$event);
		$af->merge($render);
	$af->render();
} else {
	require('_index.php');
}
