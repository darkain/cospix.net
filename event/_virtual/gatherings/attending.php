<?php

$render = ['gathering' => $db->rowId('pudl_gathering', 'gathering_id', $get->id())];
\af\affirm(404, $render['gathering']);



////////////////////////////////////////////////////////////
//ATTENDEES
////////////////////////////////////////////////////////////
$render['users'] = $db->rows([
	'us'=>_pudl_user(100),
	'ug'=>'pudl_user_gathering'
], [
	'us.user_id=ug.user_id',
	'ug.gathering_attending IN ("yes", "host")',
	'ug.gathering_id' => $get->id(),
	cpnFilterBanned(),
], 'ug.gathering_attending');

$afurl->cdnAll($render['users'], 'img', 'thumb_hash');

foreach ($render['users'] as &$item) {
	if ($user->is($item)) {
		$render['gathering']['attending'] = true;

		if ($item['gathering_attending'] === 'host') {
			$render['gathering']['host'] = true;
		}

		break;
	}
}




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////
$af->load('attending.tpl');
	$af->field('gathering', $render['gathering']);
	$af->block('users', $render['users']);
$af->render();
