<?php

$user->profile();

$text = $get->string('text');

if (empty($text))					die($user['user_email']);
if ($text === $user['user_email'])	die($user['user_email']);
if (!\af\mail\validate($text))		die($user['user_email']);


$user->profile([
	'user_attributes'	=> pudl::appendSet('verifyemail'),
	'user_email'		=> $text,
]);

echo $text;


////////////


$af->load('address.tpl');

$af->field('address', $afurl->build(['profile', 'email'], [
	'id'	=> $user->user_id,
	'hash'	=> md5($af->config->afkey() . $user->user_id . $text),
], true));


\af\mail(
	[
		'return'	=> 'return@cospix.net',
		'from'		=> '"Cospix.net Verify" <verify@cospix.net>',
		'to'		=> $text,
	],
	'Cospix.net Email Verification',
	$af->renderToString()
);
