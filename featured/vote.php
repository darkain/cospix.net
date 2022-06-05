<?php

$user->requireLogin();


$db->begin();


////////////////////////////////////////////////////////////
//CHECK VOTE COUNT
////////////////////////////////////////////////////////////
if ($db->countId('pudl_feature_vote', 'user_id', $user) > 2) {
	\af\error(422, 'Too many votes!');
}




////////////////////////////////////////////////////////////
//PULL SUBMISSION DATA
////////////////////////////////////////////////////////////
$submission = \af\affirm(404,
	$db->rowId(
		'pudl_feature_submission',
		'submission_id',
		$get->id()
	)
);




////////////////////////////////////////////////////////////
//INSERT NEW VOTE
////////////////////////////////////////////////////////////
$db->insert('pudl_feature_vote', [
	'user_id'			=> $user['user_id'],
	'submission_id'		=> $submission['submission_id'],
	'vote_timestamp'	=> $db->time(),
], true);




////////////////////////////////////////////////////////////
//UPDATE TOTAL VOTES COUTE
////////////////////////////////////////////////////////////
$db->updateCount('pudl_feature_submission', 'vote_total', [
	'submission_id' => $submission['submission_id'],
], 'pudl_feature_vote');




////////////////////////////////////////////////////////////
//ALL DONE! (force no-sync)
////////////////////////////////////////////////////////////
$db->commit(false);




////////////////////////////////////////////////////////////
//OUTPUT
////////////////////////////////////////////////////////////
if (!$get->int('jq')) $afurl->redirect($afurl->base . '/featured');

echo $db->cellId(
	'pudl_feature_submission',
	'vote_total',
	'submission_id',
	$submission
) . ' Votes';