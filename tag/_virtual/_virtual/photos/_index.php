<?php

require_once('../tag.php.inc');


$af->title = "Gallery - $af->title";

$render['more']['page'] = max($get->int('page'), 0);

//$count = ($render['more']['page'] === 0) ? 99 : 100;
$count = 100;




require('photos/photos.php.inc');


$render['gallery'] = [];




/////////////////////////////////////////////
// RENDER ALL THE THINGS
/////////////////////////////////////////////
$afurl->jq = 'photos/_index.tpl';

if ($get->int('jq')) {
	$af->mergePage($afurl->jq, $render);
} else {
	require('_index.php');
}
