<?php

$profile = $db->row('pudl_user', cpnFilterBanned(0), 'RAND()');

if (empty($profile['user_url'])) {
	$afurl->redirect("$afurl->base/$profile[user_id]");
} else {
	$afurl->redirect("$afurl->base/$profile[user_url]");
}
