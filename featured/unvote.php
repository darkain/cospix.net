<?php

$user->requireLogin();


$db->begin();


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
$db->delete('pudl_feature_vote', [
	'user_id'			=> $user['user_id'],
	'submission_id'		=> $submission['submission_id'],
]);




////////////////////////////////////////////////////////////
//UPDATE TOTAL VOTES COUTE
////////////////////////////////////////////////////////////
$db->updateCount('pudl_feature_submission', 'vote_total', [
	'submission_id' => $submission['submission_id'],
], 'pudl_feature_vote');




////////////////////////////////////////////////////////////
//ALL DONE!
////////////////////////////////////////////////////////////
$db->commit();




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