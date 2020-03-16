<?php

$af	->contentType('xml')
	->load('_index.tpl')
		->block('user', $db->group(
			['us.user_url', 'us.user_id'],
			['us'=>'pudl_user', 'ga'=>'pudl_gallery'],
			['us.user_id=ga.user_id', cpnFilterBanned()],
			'us.user_id'
		))
	->render();
