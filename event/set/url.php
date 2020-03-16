<?php


$text = $get->string('text', _GETVAR_BASIC);
//SANATIZE INPUT... VERIFY IT IS A VALID URL!!

$db->updateId('pudl_event', [
	'event_website' => $text
], 'event_id', $event);

if (empty($text)) {
	echo '&nbsp;';
} else {
	echo '<a href="' . $text . '" target="_blank">' . $text . '</a>';
}
