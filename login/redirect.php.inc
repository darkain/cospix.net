<?php

//REDIRECT TO NEW PAGE
$redirect	= $get->sessionClear('redirect');
$referer	= $get->sessionClear('referer');

if (!empty($redirect))			$afurl->redirect($redirect, 302);

//TODO: ADD CHECK TO SEE IF REFERER WAS /LOGIN/ URL, IF SO, IGNORE THIS CLAUSE
if (!empty($referer))			$afurl->redirect($referer, 302);

//TODO: VERIFY THAT REDIRECT IS WITHIN OUR ACCEPTED DOMAINS LIST (ORIGINS)
if (!empty($get('redirect')))	$afurl->redirect($get('redirect'), 302);

if (!empty($user->user_url))	$afurl->redirect([$user->user_url], 302);

$afurl->redirect([$user->user_id], 302);
