<?php



$email		= $get('auth_account');
$domain		= explode('@', $email, 2);
$password	= $get->password('auth_password');
$confirm	= $get->password('auth_confirm');


if (!strlen($password)  ||  !strlen($confirm)) {
	return false;
}




////////////////////////////////////////////////////////////////////////////////
//VALIDATE INPUT DATA
////////////////////////////////////////////////////////////////////////////////


//VALIDATE PASSWORD LENGTH
if (strlen($password) < $min_pass_length) {
	return 'Password is too short';
}


//VALIDATE PASSWORD MATCHING
if ($password !== $confirm) {
	return 'Passwords do not match';
}


//VALIDATE EMAIL ADDRESS
if (!\af\mail\validate($email)) {
	return 'Invalid email address';
}


//VALIDATE EMAIL ADDRESS
if (!\af\mail\dns( end($domain) )) {
	return 'Invalid email domain';
}


//VALIDATE EMAIL LENGTH
if (strlen($email) > 100) {
	return 'Email address is too long';
}


//TRANSACTIONS
$db->begin();
/*
$db->begin()->lock([
	'us'	=> 'pudl_user',
	'ua'	=> 'pudl_user_auth',
	'up'	=> 'pudl_user_auth',
	'pudl_user',
	'pudl_user_auth',
	'pudl_user_profile',
]);
*/

//VERIFY UNIQUE EMAIL ADDRESS
if ($db->idExists('pudl_user_profile', 'user_email', $email)) {
	//$db->unlock()->rollback();
	$db->rollback();
	return 'Email address is already in use';
}


//VERIFY UNIQUE EMAIL ADDRESS
if ($db->idExists('pudl_user_auth', 'auth_account', $email)) {
	//$db->unlock()->rollback();
	$db->rollback();
	return 'Email address is already in use';
}




////////////////////////////////////////////////////////////////////////////////
//VERIFY RECAPTCHA
////////////////////////////////////////////////////////////////////////////////
/*
$data = $afurl->post('https://www.google.com/recaptcha/api/siteverify',	[
	'secret'	=> $af->config->recaptcha['secret'],
	'response'	=> $get('g-recaptcha-response'),
	'remote'	=> af\ip::address(),
]);


$result = pudl::jsonDecode($data['content']);

if (empty($result['success'])) {
	return 'Security verification failed';
}
*/



////////////////////////////////////////////////////////////////////////////////
//INSERT NEW USER ACCOUNT
////////////////////////////////////////////////////////////////////////////////
$account = $user = afUser::create($db, [
	'user_name' => reset($domain)
]);


//SET THE ACCOUNT PASSWORD
$account->setPassword($email, $password);


//CREATE NEW ACCOUNT'S PROFILE
$db->insert('pudl_user_profile', [
	'user_id'			=> $account->user_id,
	'user_email'		=> $email,
	'user_attributes'	=> 'verifyemail'
]);


//TRANSACTIONS
//$db->unlock()->commit();
$db->commit();


//SET UP THE USER'S PREFERENCES
require('../newuser.php.inc');




////////////////////////////////////////////////////////////////////////////////
//SEND AN EMAIL TO THE ADDRESS PROVIDED
// TODO: MAKE THIS ASYNC - CREATE A "MAIL" JOB QUEUE THAT IS PROCESSED SEPARATELY
////////////////////////////////////////////////////////////////////////////////
$af->load('create.tpl');

$af->field('address', $afurl->build(['profile', 'email'], [
	'id'	=> $account->user_id,
	'hash'	=> md5($af->config->afkey() . $account->user_id . $email),
], true));

\af\mail([
	'reply'	=>  $afconfig->email,
	'from'	=> [$afconfig->email, $og['title']],
	'to'	=>  $email,
], $og['title'].' Email Verification', $af->renderToString());




////////////////////////////////////////////////////////////////////////////////
//AUTENTICATE SESSION TO USER ID
////////////////////////////////////////////////////////////////////////////////
$af->authenticate($account);




////////////////////////////////////////////////////////////////////////////////
//REDIRECT TO NEW ACCOUNT'S PROFILE
////////////////////////////////////////////////////////////////////////////////
$afurl->redirect([$account]);
