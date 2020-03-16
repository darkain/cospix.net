<?php

$badge = $db->rowId('pudl_badge', 'badge_id', $get->id());
\af\affirm(404, $badge);
\af\affirm(422, $badge['badge_creatable']);



$total = $get->int('total');
if ($total < 1) $total = 1;


echo '<pre>';
for ($x = 0; $x<$total; $x++) {
	$md5 = strtoupper(substr(md5(microtime() . rand() . $user['user_id']), 16));

	$db->insert('pudl_invite', [
		'invite_code'		=> pudl::unhex($md5),
		'invite_sender'		=> $user['user_id'],
		'invite_created'	=> $db->time(),
		'invite_badge'		=> $badge['badge_id'],
		'invite_reason'		=> empty($get('reason')) ? NULL : $get('reason'),
	]);

	echo $md5 . "\n";
//	echo "Cospix.net Badge Code\n\n\n";
}
echo '</pre>';
