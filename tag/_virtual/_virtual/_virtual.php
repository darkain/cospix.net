<?php

$path	= $router->virtual;
$first	= array_shift($path);
$set	= implode('/', $path);
$router->virtual = [$first, $set];

require('_index.php');
