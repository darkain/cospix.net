<?php


$af->title = 'Conventions';


require_once('../profile.php.inc');




$block			= 'event';

if ($af->prometheus()) {
	$block		= 'item';
}




////////////////////////////////////////////////////////////////////////////////
//LOAD ALL THE CONTENTS!!
////////////////////////////////////////////////////////////////////////////////
$render[$block] = cpn_event::collect($db, [
	'table'		=> ['ue' => 'pudl_user_event'],
	'clause'	=> [
		'ev.event_id=ue.event_id',
		'ue.user_id'	=> $profile->user_id,
	],
	'group'		=> ['event_id'],
	'order'		=> ['ev.event_start' => pudl::desc()],
]);

$render[$block]->separate('year', 'Conventions');

$render[$block]->each(function($item){
	$item['link_name']	= $item['event_name'];
	$item['name']		= \af\time::daterange($item['event_start'], $item['event_end']);
});




////////////////////////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////////////////////////
$afurl->jq		= 'conventions/_index.tpl';
if ($get->int('jq')) {
	$render[$block]->prometheus();
	$af->load($afurl->jq);
		$af->field('user', $profile);
		$af->merge($render);
	$af->render();
} else {
	require('_index.php');
}
