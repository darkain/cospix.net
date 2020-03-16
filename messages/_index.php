<?php
require_once('process.php.inc');

$user->requireLogin();


$af->title = 'Messages';


$offset = $get->int('from');
$clause = empty($offset) ? [] : ['notification_timestamp'=>pudl::lt($offset)];


class cpn_message extends pudlOrm {}



////////////////////////////////////////////////////////////
//PULL NOTIFICATION DATA
////////////////////////////////////////////////////////////
$messages = cpn_message::manage($db,
	$db->selectRows(
		'*',
		[
			'us' => _pudl_user(200),
			'no' => 'pudl_notification',
		],
		array_merge($clause, [
			'notification_user_to' => $user['user_id'],
			'no.notification_user_from=us.user_id',
			cpnFilterBanned(),
		]),
		['notification_timestamp' => pudl::desc()],
		20
	)
);

$messages->each('process_message');

$messages->each(function($item) use ($afurl){
	$item->img = $afurl->cdn($item->thumb_hash, $item->mime_id);
});




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!!
////////////////////////////////////////////////////////////
if (empty($offset)) {
	$af->header();
		$af->load('_index.tpl');
			$af->block('message', $messages);
		$af->render();
	$af->footer();
} else {
	$af->renderBlock('message.tpl', 'message', $messages);
}
