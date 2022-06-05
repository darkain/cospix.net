<?php


////////////////////////////////////////////////////////////
// WEB SERVERS
////////////////////////////////////////////////////////////
$servers		= [];
foreach ($afconfig->instances as $server) {
	$servers[]	= 'https://'.$server.'/status/check';
}
$servers[]		= 'https://beta.cospix.net/status/check';
$servers[]		= 'http://router-0.tac.cospix.net';
$servers[]		= 'http://router-1.tac.cospix.net';
$servers[]		= 'http://router-2.tac.cospix.net';




////////////////////////////////////////////////////////////
// RENDER SHIT!
////////////////////////////////////////////////////////////
$router->replace('_altaform', 'status');
