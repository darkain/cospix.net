<?php
$user->requireLogin();

$af->title = 'My Checklists';


require_once('../profile.php.inc');



////////////////////////////////////////////////////////////
//OBJECT TYPE
////////////////////////////////////////////////////////////
$render['object'] = [
	'type'	=> 'profile',
	'id'	=> $profile['user_id'],
];




////////////////////////////////////////////////////////////
//QUERY
////////////////////////////////////////////////////////////
$render['data'] = '';

$data = $db->selectRows(
	['*', 'JSON_checklist_data'=>pudl::column_json(pudl::column('checklist_data'))],
	'pudl_checklist',
	['user_id' => $user['user_id']]
);

foreach ($data as &$item) {
	$af->load('checklist/body.tpl');
		$af->field('data', $item);
		$af->block('list', $item['checklist_data']);
	$render['data'] .= $af->renderToString();
} unset($item);




////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////
$afurl->jq = 'checklists/_index.tpl';

if ($get->int('jq')) {
	$af->load($afurl->jq);
		$af->field('user', $profile);
		$af->merge($render);
	$af->render();
} else {
	require('_index.php');
}
