<?php
$user->requireAccessStaff('event', $event);

$id = $get->id();
$event = $db->rowId('pudl_event', 'event_id', $id);
if (empty($event)) \af\error(404);


$event['details'] = array_flip(explode(',', $event['event_details']));
foreach ($event['details'] as &$val) {$val=1;} unset($val);


//Pull list of possible social link types
//TODO: add this parsing of ENUM/SET information directly to PUDL for future usage!
$fields	= $db->listFields('pudl_event_social');
$types	= $fields['social_type']['Type'];
$types	= str_replace('enum(', '', $types);
$types	= str_replace(')', '', $types);
$types	= str_replace("'", '', $types);
$types	= explode(',', $types);
$types	= array_flip($types);

foreach ($types as &$item) { $item=NULL; } unset($item);
ksort($types, SORT_FLAG_CASE|SORT_STRING);


//Pull social links!
$links = $db->rowsId('pudl_event_social', 'event_id', $id);
foreach($links as $item) {
	$types[ $item['social_type'] ] = $item['social_url'];
}


$af->load('_index.tpl');
	$af->field('event', $event);
	$af->block('social', $types);
$af->render();
