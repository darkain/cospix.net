<?php

$youtube = $db->rowId('pudl_youtube', 'youtube_id', $event['event_youtube']);

$af	->load('youtube.tpl')
		->field('event',	$event)
		->field('youtube',	$youtube)
	->render();
