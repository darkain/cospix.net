<?php

$gathering = $db->rowId('pudl_gathering', 'gathering_id', $get->id());
\af\affirm(404, $gathering);


if (!$user->hasAccessStaff('event', $event)) {
	\af\affirm(401,
		$db->clauseExists('pudl_user_gathering', [
			'user_id'				=> $user['user_id'],
			'gathering_id'			=> $get->id(),
			'gathering_attending'	=> 'host',
		])
	);
}
