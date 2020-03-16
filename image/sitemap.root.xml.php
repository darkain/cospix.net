<?php

$key = [];
for ($i=0;$i<4096; $i++) {
	$key[] = str_pad(dechex($i), 3, '0', STR_PAD_LEFT);
}

$af	->contentType('xml')
	->load('sitemap.root.xml.tpl')
		->block('list', $key)
	->render();
