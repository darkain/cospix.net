<?php

$af	->contentType('xml')
	->load('sitemap.tpl')
		->block('user', $db->rows(
			['us'=>'pudl_user', 'uo'=>'pudl_user_profile'],
			[cpnFilterBanned(), 'us.user_id=uo.user_id']
		))
	->render();
