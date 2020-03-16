<?php

if ($af->prometheus()) {
	$afurl->redirect(['gallery']);
}

$type	= 'costume';
$verb	= 'Cosplays';
$af->title	= 'Recently Updated Cosplays';

require('gallery/_index.php');
