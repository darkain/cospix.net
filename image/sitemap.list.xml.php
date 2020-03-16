<?php

$hex = str_replace(['sitemap.list.', '.xml'], [''], $router->virtual[0]);
$hex = str_pad(strtoupper(dechex(hexdec($hex))), 3, '0', STR_PAD_LEFT);
if (strlen($hex) !== 3) \af\error(404);


$af	->contentType('xml')
	->load('sitemap.list.xml.tpl')
		->block('list', $db->group(
			['val'=>pudl::raw('LEFT(HEX(fl.file_hash),6)')],
			['fl'=>'pudl_file', 'gi'=>'pudl_gallery_image'],
			[
				'fl.file_hash' => pudl::between(
					pudl::unhex($hex.'0'),
					pudl::unhex($hex.'F')
				),
				'gi.file_hash=fl.file_hash',
			],
			'val'
		))
	->render();
