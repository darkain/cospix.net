<?php
$user->requireLogin();

$comment = $db->rowId('pudl_comment', 'comment_id', $get->id());
\af\affirm(404, $comment);

$delete = false;

if ($user->isStaff()) {
	$delete = true;
}

if ($af->type($comment['object_type_id']) === 'profile'  &&  $user->is($comment)) {
	$delete = true;
}

if ($user->is($comment)) {
	$delete = true;
}

if (!$delete) \af\error(401);

$db->deleteId('pudl_comment', 'comment_id', $comment);
