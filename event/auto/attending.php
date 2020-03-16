<?php

////////////////////////////////////////////////////////////////////////////////
// EXPLODE SEARCH INTO MULTILE PARTS
////////////////////////////////////////////////////////////////////////////////
$clause	= [];
$term	= explode(' ', str_replace(
	['+', "\t", "\r", "\n", "\0", "\xC2\xA0"],
	' ', $get->term
));




////////////////////////////////////////////////////////////////////////////////
// PROCESS EACH PART - SEARCH EVENT NAME, VENUE, LOCATION
////////////////////////////////////////////////////////////////////////////////
foreach ($term as $item) {
	$item = trim($item);
	if ($item === '') continue;

	$clause[] = [
		'ev.event_name'		=> pudl::like($item),
		'ev.event_venue'	=> pudl::like($item),
		'ev.event_location'	=> pudl::like($item),
	];
}




////////////////////////////////////////////////////////////////////////////////
// SEARCH DATABASE AND SHOW RESULTS
////////////////////////////////////////////////////////////////////////////////
$af->json(
	$db->selectRows([
			'id'	=> 'ev.event_id',
			'label'	=> 'ev.event_name',
		], [
			'ev' => ['pudl_event', [
				'left'	=> ['ue' => 'pudl_user_event'],
				'on'	=> [
					'ev.event_id=ue.event_id',
					'ue.user_id' => $user->id(),
				]
			]]
		], $clause, [
			'user_id'		=> pudl::dsc(),
			'event_start'	=> pudl::dsc(),
			'event_name',
		],
		10
	)
);
