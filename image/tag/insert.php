<?php

require('image.php.inc');

//INSERT THE THINGS!!
cpnTag::insertHash(pudl::unhex($image['hash']), 'image', $get->id());

$af->ok();
