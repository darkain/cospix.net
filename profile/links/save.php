<?php

$user->requireLogin();

$id = $get->id();
$profile = $db->rowId('pudl_user', 'user_id', $id);
\af\affirm(404, $profile);
\af\affirm(401, $user->is($profile));


$social = $get->stringArray('social');
foreach ($social as $key => $val) {
	if (empty($val)) {
		$db->delete('pudl_user_social', [
			'user_id'		=> $id,
			'social_type'	=> $key,
		]);

	} else {
		$db->insert('pudl_user_social', [
			'user_id'		=> $id,
			'social_type'	=> $key,
			'social_url'	=> $val,
		], true);
	}
}
