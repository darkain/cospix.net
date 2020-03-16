<?php

$af->title  = 'Profiles Starting With Numbers';




////////////////////////////////////////////////////////////////////////////////
//BUILD THE CUSTOM CLAUSE
////////////////////////////////////////////////////////////////////////////////
$clause = [
	'us.user_name' => pudl::regexp(pudl::raw('^[0-9]'))
];




////////////////////////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS
////////////////////////////////////////////////////////////////////////////////
require('list.php.inc');
