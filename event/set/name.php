<?php


$text = $get->string('text');
//TODO: SANATIZE INPUT... NO LOWER ASCII CHARACTERS!! NO SPECIAL HTML CHARACTERS


$db->updateId(
	'pudl_event',
	['event_name' => $text],
	'event_id', $event
);


$db->insert('pudl_event_rename', [
	'event_id'		=> $event['event_id'],
	'event_name'	=> $event['event_name'],
], true);


echo $text;
