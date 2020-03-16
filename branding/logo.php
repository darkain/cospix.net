<?php

$path = __DIR__ . '/../static/';

switch ($get->type) {
	case 'svg':
		$path .= 'cospix-logo-color.svg';
	break;

	case 'png':
		$path .= 'cospix-logo-color.png';
	break;

	default: \af\error(404);
}

$af->contentType('svg');

header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename='.basename($path));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($path));

readfile($path);
