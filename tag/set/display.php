<?php
$user->requireStaff();


$db->updateId('pudl_group',	[
	'group_display' => $get->int('display')
], 'group_id', $get->id());


$af->ok();
