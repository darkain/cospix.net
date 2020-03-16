<?php

//VERIFY PERMISSIONS
require('permissions.php.inc');


$description = $get('value');


$db->updateId('pudl_gathering', [
	'gathering_description' => $description,
], 'gathering_id', $get->id());


echo afString::linkify( $description );
