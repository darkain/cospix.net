<?php


$text = $get->filter('text', FILTER_VALIDATE_URL);

if (empty($text)) $text = NULL;



$db->updateId('pudl_event', [
	'event_website' => $text
], 'event_id', $event);



if (empty($text)) {
	echo '&nbsp;';
} else {
	// TODO: convert this over to TBX
	echo '<a href="' . $text . '" target="_blank">' . $text . '</a>';
}
