<?php

/*
	NOTE: THIS IS A TESTING SCRIPT OF THE RANKING SYSTEM
	THIS IS NOT INTENDED TO BE PUBLICLY USED, ONLY TO
	ENSURE THAT MULTI-SOURCE RANKING IS WORKING AT LEAST
	SOMEWHAT EFFECTIVELY!
*/

$minrank	= 0;
$today		= floor($db->time() / AF_DAY);
$data		= [];	//OUTPUT DATA
$tags		= [];	//LISTING OF TAG IDS TO IGNORE
$images		= [];	//LISTING OF IMAGE HASHES TO IGNORE
$events		= [];	//LISTING OF EVENT IDS TO IGNORE
$galleries	= [];	//LISTING OF GALLERY IDS TO IGNORE


$profile = $db->rowId('pudl_user_profile', 'user_id', $user);


//require('daily-photos.php.inc');
//require('recent-galleries.php.inc');
//require('trending-series.php.inc');
//require('trending-images.php.inc');
require('recent-events.php.inc');
require('event-distance.php.inc');


ksort($data, SORT_NUMERIC);
\af\dump($data);
