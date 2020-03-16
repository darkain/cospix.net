<?php

$hex = str_replace(['sitemap.item.', '.xml'], [''], $router->virtual[0]);
$hex = str_pad(strtoupper(dechex(hexdec($hex))), 6, '0', STR_PAD_LEFT);
if (strlen($hex) !== 6) \af\error(404);


$af	->contentType('xml')
	->load('sitemap.item.xml.tpl')
		->block('image', $db->select(
			'*',
			['fl'=>'pudl_file', 'gi'=>'pudl_gallery_image'],
			[
				'fl.file_hash' => pudl::between(
					pudl::unhex($hex.'00'),
					pudl::unhex($hex.'FF')
				),
				'gi.file_hash=fl.file_hash',
			]
		))
	->render();
