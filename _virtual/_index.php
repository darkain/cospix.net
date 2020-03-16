<?php

//Fix for all the crap that Google Webmaster tools throws at us!
if (count($router->virtual) === 1  &&  substr($router->virtual[0], -4) === '.php') {
	$afurl->redirect("$afurl->host$afurl->base");
}

//TODO: test for EVENTS first!
// ^^^ assuming we want shorter URLs for events, too


//Update URL to act as if we're in the /profile/ directory
return $router->reparse('profile');
