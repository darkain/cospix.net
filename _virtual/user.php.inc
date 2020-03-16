<?php

$profile = [];

if (ctype_digit($router->virtual[0])) {
	if ($router->virtual[0] < 1) \af\error(404);
	$profile = $db->row('pudl_user', ['user_id'=>$router->virtual[0], cpnFilterBanned(0)]);

	if (!empty($profile['user_url'])) {
		$path  = $afurl->base . '/';
		$path .= preg_replace("/^\/$profile[user_id]/", $profile['user_url'], $afurl->url);
		$afurl->redirect($path);
	}

} else if (ctype_alnum($router->virtual[0])) {
	$profile = $db->row('pudl_user', ['user_id'=>$router->virtual[0], cpnFilterBanned(0)]);
}
\af\affirm(404, $profile);

if (empty($profile['user_url'])) $profile['user_url'] = $profile['user_id'];

$router->id = $profile['user_id'];

chdir('../profile/');
