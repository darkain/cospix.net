<?php

//VERIFY PERMISSIONS
require('permissions.php.inc');

$text = $get->string('text');
//TODO: SANATIZE INPUT... NO LOWER ASCII CHARACTERS!! NO SPECIAL HTML CHARACTERS

$db->updateId('pudl_gathering', [
	'gathering_name' => $text,
], 'gathering_id', $id);

echo $text;
