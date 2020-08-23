<?php

//TODO: move this into the main pudlGalera class!
return;
/*
$servers = $db->offlineServers();
foreach ($servers as $server) {
	$mysqli = mysqli_init();

	$ok = @$mysqli->real_connect(
		"p:$server",
		$site['pudl_username'],
		$site['pudl_password'],
		$site['pudl_database']
	);

	if (!$ok) $ok = @$mysqli->real_connect(
		$server,
		$site['pudl_username'],
		$site['pudl_password'],
		$site['pudl_database']
	);

	if ($ok) {
		$db->onlineServer($server);
	}
};
*/
