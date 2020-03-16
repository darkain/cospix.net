<?php


////////////////////////////////////////////////////////////
//SWITCH TO ANONYMOUS ACCOUNT
////////////////////////////////////////////////////////////
$user = new afAnonymous($db);




////////////////////////////////////////////////////////////
//PROCESS INCOMING FILE
////////////////////////////////////////////////////////////
$import	= new \af\import($af, $db);
$file	= $import->upload();




////////////////////////////////////////////////////////////
//UPDATE EVENT ICON
////////////////////////////////////////////////////////////
$db->updateId(
	'pudl_event',
	['event_icon' => $file['file_hash']],
	'event_id', $event
);




////////////////////////////////////////////////////////////
//OUTPUT
////////////////////////////////////////////////////////////
$af->json($file);
