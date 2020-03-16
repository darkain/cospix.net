<?php
$router->virtual[0] = str_replace('%20', '+', $router->virtual[0]);
$router->virtual[0] = str_replace(' ', '+', $router->virtual[0]);
$afurl->redirect("$afurl->base/tag/{$router->virtual[0]}", 302);
