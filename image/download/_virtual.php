<?php

\af\affirm(404, $hash = @hex2bin($router->virtual[0]));
\af\affirm(404, $data = $db->rowId('pudl_file', 'file_hash', $hash));

$path = $af->path() . 'files/' . $afurl->cdnPath($data['file_hash']);
\af\affirm(404, is_file($path));

$mime = new \af\mime($data['mime_id'], $db);

header('Content-Type: ' . $mime);
header('Content-Transfer-Encoding: Binary');

header(
	'Content-Disposition: attachment; filename="' .
	bin2hex($data['file_hash']) . '.' . $mime->ext() . '"'
);

readfile($path);
