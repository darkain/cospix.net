<?php
$user->requireLogin();


//PULL DISCUSSION OBJECT
$discussion = $db->rowId('pudl_discussion', 'discussion_id', $get->id());
\af\affirm(404, $discussion);

//VERIFY OWNERSHIP
\af\affirm(401, $user->is($discussion));


//YES, DELETE
if ($get->int('confirm')) {
	//BUILD CLAUSE
	$clause = [
		'object_id'			=> $get->id(),
		'object_type_id'	=> $af->type('discussion'),
	];

	//DELETE ALL THE THINGS
	$db->begin();
		$db->deleteId('pudl_discussion', 'discussion_id', $discussion);
		$db->delete('pudl_discussion',		$clause);
		$db->delete('pudl_comment',			$clause);
		$db->delete('pudl_activity',		$clause);
		$db->delete('pudl_notification',	$clause);
	$db->commit();

	$af->ok();
}


//DISPLAY CONFIRMATION
//TODO: "REMOVE" AND "DELETE" NEED SEPARATE URLS
$af->renderField('delete.tpl', 'post', $discussion);
