<?php
return;
//$user->requireStaff();

$time = $db->time();

$events = $db->rows('pudl_event', [
	'event_start' => pudl::between($time, $time+AF_WEEK),
	cpnFilterCanceled(),
], 'event_name');

if (empty($events)) return;


$text = "Here are your conventions this weekend! Know of one we don't? Link us in the comments!\n";
foreach ($events as &$event) {
	$text .= "\n$event[event_name] in $event[event_location]\n";
	$text .= "$afurl->host$afurl->base/event/" . rawurlencode(strtolower($event['event_name'])) . "\n";
} unset($event);


require_once('_facebook/src/facebook.php');

$facebook = new Facebook([
	'appId'		=> $afconfig->facebook['id'],
	'secret'	=> $afconfig->facebook['secret'],
	'cookie'	=> false,
]);


//TODO: WE NEED TO MOVE THE PNG CREATION TO OUR OWN SYSTEM
$attachment = [
	'caption'	=> $text,
	'url'		=> 'http://pdf.hagensautoparts.com/png.php?url=' . rawurlencode('beta.cospix.net/calendar/week?year='.date('Y').'&week='.date('W')),
];

try {
	//	GET THE USER TOKEN
	$fbuser = $db->rowId('pudl_user_facebook', 'pudl_user_id', 1);
	$facebook->setAccessToken($fbuser['fb_auth_token']);

	//	USE THE USER TOKEN TO GET PAGE ACCESS TOKEN
	$token = $facebook->api(
		'/'.$afconfig->facebook['page_id'],
		'get',
		['fields'=>'access_token']
	);

	if (empty($token)) \af\error(500, 'UNABLE TO GET TOKEN FOR PAGE');
	$facebook->setAccessToken($token['access_token']);

	//	POST TO THE PAGE AS THE PAGE ITSELF
	$facebook->api(
		'/'.$afconfig->facebook['page_id'].'/photos/',
		'post',
		$attachment
	);

	echo 'GOOD!';

} catch (FacebookApiException $e) {
	\af\dump($e);
}
