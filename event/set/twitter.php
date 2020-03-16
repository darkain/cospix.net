<?php


$text = trim(str_replace(
	['http://twitter.com/', 'https://twitter.com/', '@', '/'],
	'', $get->string('text')
));


$db->updateId(
	'pudl_event',
	['event_twitter' => $text],
	'event_id', $event
);

echo '<a target="_blank" href="http://twitter.com/' . rawurlencode($text);
echo '">@' . htmlspecialchars($text) . '</a>';
