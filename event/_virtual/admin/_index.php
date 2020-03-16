<?php

require('../event.php.inc');

$user->requireAccessStaff('event', $event);


$af->title = 'Admin';
$og['description'] = 'Admin page for ';


$render = [];


if (!empty($event['event_added_by'])) {
	$event['added_by'] = $db->rowId('pudl_user', 'user_id', $event['event_added_by']);
}




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////
$afurl->jq = 'admin/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq);
		$af->field('event',	$event);
	$af->render();
} else {
	require('_index.php');
}

