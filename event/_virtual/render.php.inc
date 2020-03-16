<?php

$af	->header()
		->load($afurl->jq)
			->field('event',	$event)
			->field('profile',	$profile)
			->merge($render)
		->render()
	->footer();
