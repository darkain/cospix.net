<?php

$af->title = 'Create New Badge Codes';

$af	->header()
		->load('add.tpl')
			->block('badge', $db->rowsId('pudl_badge', 'badge_creatable', 1))
		->render()
	->footer();