<?php
$user->requireLogin();




//TRANSACTIONS!!
$db->begin();



//ADMIN, GIVING OUT A BADGE
if ($user->isStaff()  &&  $get->id('badge')) {
	$data	= $db->rowId('pudl_badge', 'badge_id', $get->id('badge'));
	$add	= $get->id();
	if (empty($add)) $add = $user['user_id'];


//BADGE CODE
} else {
	$add	= $user['user_id'];
	$code	= $get->hash('code');
	$data	= $db->rowId('pudl_badge', 'badge_code', pudl::unhex($code));

	if (empty($data)) $data = $db->row([
		'iv' => 'pudl_invite',
		'ba' => 'pudl_badge'
	], [
		'iv.invite_badge=ba.badge_id',
		'iv.invite_receiver'	=> NULL,
		'iv.invite_code'		=> pudl::unhex($code),
	]);
}



//YOU SUCK AT THIS!!
if (empty($data)) {
	echo 'Invalid Badge Code';
	return;
}



//CHECK IF USER ALREADY HAS THE BADGE
if (!empty($code)) {
	if ($db->clauseExists('pudl_user_badge', [
		'user_id'	=> $add,
		'badge_id'	=> $data['badge_id']
	])) {
		echo 'You already have this badge';
		return;
	}
}



//CLEAR OUT THE INVITE CODE
if (!empty($data['invite_code'])) {
	$db->update('pudl_invite', [
		'invite_receiver' => $add,
		'invite_accepted' => $db->time()
	], [
		'invite_code'		=> pudl::unhex($code),
		'invite_receiver'	=> NULL,
	]);
}



//GIVE THE USER THE BADGE
$db->insert('pudl_user_badge', [
	'user_id'			=> $add,
	'badge_id'			=> $data['badge_id'],
	'badge_timestamp'	=> $db->time(),
	'badge_reason'		=> empty($data['invite_reason']) ? NULL : $data['invite_reason'],
], 'user_id=user_id');



//ACTIVITY!!!
(new \af\activity($af, $user))->add(
	$data['badge_id'],
	'badge',
	'earned the',
	$add
);


//LIFETIME AD-FREE ACCOUNT!!
if ($data['badge_id'] == '5') {
	$user->update(['user_adfree' => '253402300799']);
}



//TRANSACTIONS!!
$db->commit();

echo '<script>refresh();</script>';
