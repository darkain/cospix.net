<?php

require('../profile.php.inc');


$af	->contentType('xml')
	->load('sitemap.xml/_index.tpl')
		->field('profile', $profile)
		->block('gallery', $db->rowsId('pudl_gallery', $profile))
	->render();
