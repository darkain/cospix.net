<?php

//VERIFY PERMISSIONS
require('permissions.php.inc');

$af->load('edit.tpl');
	$af->field('gathering', $gathering);
$af->render();
 