<?php

//VERIFY PERMISSIONS
require('permissions.php.inc');

$start	= $get->timestamp('start');
$end	= $get->timestamp('end');

if (empty($start) ||  empty($end)) \af\error(422, 'Invalid Time');

$db->updateId('pudl_gathering', [
	'gathering_start'	=> $start,
	'gathering_end'		=> $end,
], 'gathering_id', $get->id());
