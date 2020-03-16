<?php


$rows = $db->group(
	['social_type', 'total' => pudl::count()],
	'pudl_user_social',
	false,
	'social_type',
	['total'=>pudl::dsc()]
)->complete();


$af	->header()
		->load('social.tpl')
			->block('social', $rows)
		->render()
	->footer();
