<?php

$af->title = 'Discussion';

require_once('../event.php.inc');


$af->script($afurl->static . '/js/underscore.js');
$af->script($afurl->static . '/js/jquery-textntags.js');
$af->style( $afurl->static . '/css/jquery-textntags.css');



/////////////////////////////////////////////
// DISCUSSION OBJECT
/////////////////////////////////////////////
$discussion = $db->row([
	'us' => _pudl_user(100),
	'ds' => 'pudl_discussion',
], [
	'us.user_id=ds.user_id',
	'discussion_id' => $event['page_id'],
	cpnFilterBanned(),
]);

\af\affirm(404, $discussion);

$render['posts'] = [$discussion];




/////////////////////////////////////////////
// DISCUSSION COMMENTS
/////////////////////////////////////////////
foreach ($render['posts'] as &$post) {
	$post['comments'] = $db->rows([
		'us' => _pudl_user(50),
		'cm' => 'pudl_comment'
	], [
		'us.user_id=cm.commenter_id',
		'cm.object_id'		=> $post['discussion_id'],
		'cm.object_type_id'	=> $af->type('discussion'),
	], 'comment_timestamp');

	foreach ($post['comments'] as &$comment) {
		$comment['timesince'] = \af\time::since($comment['comment_timestamp']);
		$comment['img'] = $afurl->cdn($comment, 'thumb_hash');
	}
}




/////////////////////////////////////////////
// RENDER ALL THE THINGS
/////////////////////////////////////////////
$afurl->jq = 'discussion/_virtual.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq);
		$af->field('event', $event);
		$af->block('posts', $render['posts']);
	$af->render();
} else {
	require('_index.php');
}

