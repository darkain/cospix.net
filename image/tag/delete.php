<?php

require('image.php.inc');

//DELETE THE THINGS!!
cpnTag::deleteHash(pudl::unhex($image['hash']), 'image', $get->id());

$af->ok();
