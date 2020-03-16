<?php
$user->requireLogin();

$lfs = $db->rowId('pudl_looking', 'lfs_id', $get->id());
\af\affirm(404, $lfs);
\af\affirm(401, $usr->is($lfs));

$db->updateId('pudl_looking', [
	'lfs_timestamp' => $db->time()
], 'lfs_id', $get->id());

echo $db->time();
