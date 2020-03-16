<?php
/*
create checklists directly from gallery/costume pages

make note that checklists are private data only, not public
ooorrrrr make this toggleable? make checklists sharable
 - visual only at first
 - editable by friends later on (or at the same time!?)
*/

$af->title = 'Checklists';
$og['description'] = 'My checklists for ';

require_once('../event.php.inc');

$user->requireLogin();



////////////////////////////////////////////////////////////
//OBJECT TYPE
////////////////////////////////////////////////////////////
$render['object'] = [
	'type'	=> 'event',
	'id'	=> $event['event_id']
];



////////////////////////////////////////////////////////////
//QUERY
////////////////////////////////////////////////////////////
$render['data'] = '';

$data = $db->selectRows(
	['*', 'JSON_checklist_data'=>pudl::column_json(pudl::column('checklist_data'))],
	'pudl_checklist',
	['event_id'=>$event['event_id'], 'user_id'=>$user['user_id']]
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
$afurl->jq = 'checklist/checklist.tpl';

if ($get->int('jq')) {
	$af->mergePage($afurl->jq, $render);
} else {
	require('_index.php');
}
