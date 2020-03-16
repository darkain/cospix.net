<?php

$hash = $get->hash();
$row = $db->rowId('pudl_tool_hotel', 'hash', pudl::unhex($hash));

if (empty($row)) {
	$hash = bin2hex(openssl_random_pseudo_bytes(16));
}

$data = ['total' => $get->float('total')];

$name = $get->stringArray('n');
for ($i=1;$i<=10;$i++) {
	if (!empty($name[$i])) $data['name'][$i] = $name[$i];

	$check = $get->intArray("c$i");
	for ($j=0;$j<7;$j++) {
		if (!empty($check[$j])) $data["check$i"][$j] = 1;
	}
}


$json = json_encode($data);
if ($json === '{"total":0}') {
	if (!empty($row)) {
		$db->deleteId('pudl_tool_hotel', 'hash', pudl::unhex($hash));
	}
	return;
}


$db->insert('pudl_tool_hotel', [
	'hash' => pudl::unhex($hash),
	'json' => $json,
], true);

echo $hash;
