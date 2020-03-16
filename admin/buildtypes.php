<?php

$data  = "<?php\n\n";
$data .= "//NOTE: THIS FILE IS AUTO-GENERATED. DO NOT EDIT DIRECTLY\n";
$data .= "//      GENERATE THIS SCRIPT VIA /admin/buildtypes\n\n\n";
$data .= "altaform::\$types = [\n";

$types = $db->rows('pudl_object_type', false, 'object_type_id');
foreach ($types as $key => $val) {
	$id		= (int) $val['object_type_id'];
	$name	= preg_replace('/[^a-z]/', '', $val['object_type_name']);
	$data .= "\t$id\t=> '$name',\n";
}

$data .= "];\n";

echo '<pre>'.htmlspecialchars($data).'</pre>';

file_put_contents('../_altaform/types.php.inc', $data);
