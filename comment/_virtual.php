<?php

//TODO:	when loading an individual comment:
//		it should figure out parent object, and redirect there instead!

$comments = [$db->row([
	'us' => _pudl_user(50),
	'cm' => 'pudl_comment'
], [
	'us.user_id=cm.commenter_id',
	'cm.comment_id' => $router->id,
	cpnFilterBanned(),
], [
	'comment_id'=>pudl::dsc()
])];


if (empty($comments)  ||  empty($comments[0])) \af\error(404);

foreach ($comments as $key => &$val) {
	$val['timesince'] = \af\time::since($val['comment_timestamp']);
	$val['img'] = $afurl->cdn($val, 'thumb_hash');
}

$af->header();
	$af->renderBlock('_virtual.tpl', 'comment', $comments);
$af->footer();
