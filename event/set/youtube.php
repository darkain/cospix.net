<?php




$youtube = $get->string('youtube');
if (empty($youtube)) {
	$db->updateId(
		'pudl_event',
		['event_youtube' => NULL],
		'event_id', $event
	);

	echo '<script>refresh()</script>';
	return;
}



$ytid = (new \af\youtube($af, $db))->importPath($youtube);

$db->updateId(
	'pudl_event',
	['event_youtube' => empty($ytid) ? NULL : $ytid],
	'event_id', $event
);


echo '<script>refresh()</script>';
