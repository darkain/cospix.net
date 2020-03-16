<?php \af\error(404);
/*
$user->requireAdmin();


$db->begin();


$item = $db->rowId('pudl_feature_submission', 'user_id', $user);
if (!empty($item)) {
	$item['feature_timestamp'] = $db->time();
	$db->insert('pudl_feature', $item);
	$db->deleteId('pudl_feature_submission', 'submission_id', $item);
}


$rows = $db->rows('pudl_feature_submission');

foreach ($rows as $row) {
	$db->updateCount('pudl_feature_submission', 'vote_total', [
		'submission_id' => $row['submission_id'],
	], 'pudl_feature_vote');
}


$db->commit();


$af->ok();
*/
