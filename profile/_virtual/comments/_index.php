<?php
$user->requireStaff();

$af->title = 'Comments';


require_once('../profile.php.inc');



////////////////////////////////////////////////////////////
//LOAD UP ALL COMMENTS
////////////////////////////////////////////////////////////
$render['comment'] = $db->rows(
	['us'=>_pudl_user(50), 'co'=>'pudl_comment'],
	['commenter_id'=>$profile['user_id'], 'co.commenter_id=us.user_id'],
	['comment_id'=>pudl::dsc()]
);


$afurl->cdnAll($render['comment'], 'img', 'thumb_hash');


foreach ($render['comment'] as &$item) {
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
	}
} unset($item);




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////
$afurl->jq = 'comments/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq);
		$af->field('user', $profile);
		$af->merge($render);
	$af->render();
} else {
	require('_index.php');
}
