<?php

//ADMIN ACCESS ONLY!
$user->requireStaff();


//PULL MOST RECENT WINNER
$last = $db->row('pudl_feature', false, ['feature_timestamp'=>pudl::dsc()]);


//FORCE TIMESTAMP TO SYNC TO PREVIOUS TIME
$db->time($last['feature_timestamp'] + AF_DAY);


//CHECK IF NEW TIMESTAMP IS IN THE FUTURE
if ($db->time() > $af->time()) {
	echo 'Already up to date!';
	return;
}


//PROCESS CRON REQUEST MANUALLY!
require_once('cron.php.inc');
