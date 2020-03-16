<?php

$user->requireLogin();


$location = $geo->clean($get->value);


$user->update([
	'user_location'	=> $location,
	'user_lat'		=> NULL,
	'user_lon'		=> NULL,
]);


echo $location;
