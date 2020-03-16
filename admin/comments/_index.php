<?php

$af->title = 'Recent User Comments';



$comments = $db->selectRows(
	'*',
	['us'=>_pudl_user(50), 'co'=>'pudl_comment'],
	['co.commenter_id=us.user_id', cpnFilterBanned()],
	['comment_id'=>pudl::dsc()],
	100
);

$afurl->cdnAll($comments, 'img', 'thumb_hash');


foreach ($comments as &$item) {
	$item['timesince'] = \af\time::since($item['comment_timestamp']);

	switch ($af->type($item['object_type_id'])) {
		case 'image':
			$item['link'] = "$afurl->base/image/" . bin2hex($item['file_hash']);
			if (!empty($item['object_id'])) $item['link'] .= '?gallery=' . $item['link'];
		break;

		case 'gallery':
			$gallery = $db->rowId('pudl_gallery', 'gallery_id', $item['object_id']);
			if (!empty($gallery)) {
				$item['link'] = "$afurl->base/$gallery[user_id]/$gallery[gallery_type]/$item[object_id]";
			}
		break;

		//TODO: ADD SUPPORT FOR MORE COMMENT SOURCES HERE!!
	}
} unset($item);


$af->header();
	$af->load('_index.tpl');
		$af->block('comment', $comments);
	$af->render();
$af->footer();
