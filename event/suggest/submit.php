<?php
$user->requireLogin();


$af->title = 'Submission Complete';


$body =	"@vincentmilumjr\r\n" .
		"@kamakazikorean13\r\n" .
		"@brianewell\r\n" .
		"@cospixnet\r\n" .
		"User: $user[user_id] - $user[user_name] - $afurl->host$afurl->base/$user[user_url]/\n\n" .
		"Venue: " . $get('venue') . "\n\n" .
		"Location: " . $get('location') . "\n\n" .
		"Dates: " . $get('start') .
		" --- " . $get('end') . "\n\n" .
		"Web Site: " . $get('site') . "\n\n" .
		"Facebook: " . $get('facebook') . "\n\n" .
		"Twitter: " . $get('twitter') . "\n\n" .
		"Additional Notes: \n" . $get('data');

mail(
	'cospixnet+ayuwpvzjvmmqdmcxuiac@boards.trello.com',
	$get('name'),
	$body
);

$af->renderPage('submit.tpl');
