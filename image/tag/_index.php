<?php

require('image.php.inc');




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS
////////////////////////////////////////////////////////////
$af->load('_index.tpl');
	$af->field('image', $image);
$af->render();
