<?php

$af->title = 'Discussion';
$og['description'] = 'Discussions about ';

require_once('../event.php.inc');


$af->script($afurl->static . '/js/underscore.js');
$af->script($afurl->static . '/js/jquery-textntags.js');
$af->style( $afurl->static . '/css/jquery-textntags.css');



/////////////////////////////////////////////
// DISCUSSION OBJECTS
/////////////////////////////////////////////
$render['posts'] = $db->rows([
	'us' => _pudl_user(100),
	'ds' => 'pudl_discussion',
], [
	cpnFilterBanned(),
	'us.user_id=ds.user_id',
	'ds.object_id'		=> $event['event_group'],
	'ds.object_type_id'	=> $af->type('event'),
], [
	'discussion_updated'=>pudl::dsc()
]);




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
$afurl->jq = 'discussion/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq);
		$af->field('event', $event);
		$af->block('posts', $render['posts']);
	$af->render();
} else {
	require('_index.php');
}
