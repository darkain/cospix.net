<?php


$af	->contentType('xml')
	->load('sitemap.tpl')
		->block('event', $db->rows('pudl_event'))
	->render();
