<?php


function render_comments($id, $type) {
	global $af, $db, $user;

	$comments = $db->rows([
		'us' => ['pudl_user',
			['left'=>['th'=>'pudl_file'], 'on'=>'us.user_icon=th.file_parent'],
			['left'=>['mt'=>'pudl_mimetype'], 'on'=>'mt.mime_id=th.mime_id'],
		],
		'cm' => 'pudl_comment',
	], [
		'us.user_id=cm.commenter_id',
		'cm.object_id'		=> $id,
		'cm.object_type_id'	=> $af->type($type),
		cpnFilterBanned(),
	], [
		'comment_id'=>pudl::dsc()
	]);


	$delete = false;
	if ($user->isStaff()) $delete = true;
	if ($type === 'profile'  &&  $user->is($id)) $delete = true;

	if ($comments !== false) foreach ($comments as &$val) {
		$val['comment_timesince'] = \af\time::since($val['comment_timestamp']);
		$val['user_pic_url'] = $afurl->cdn($val);

		if ($delete) {
			$val['comment_delete'] = 1;
		} else if ($user->is($val['commenter_id'])) {
			$val['comment_delete'] = 1;
		} else {
			$val['comment_delete'] = 0;
		}
	}

	return $comments;
}
