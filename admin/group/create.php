<?php

$label = $get->string('label');
\af\affirm(422, $label);

$db->insert('pudl_group_type',[
	'group_type_name' => $label,
], true);
