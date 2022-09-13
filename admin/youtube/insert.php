<?php



$links	= $get('links');
$links	= str_replace(["\t", "\r", ' '], "\n", $links);
$list	= explode("\n", $links);

foreach ($list as $item) {
	$item = trim($item);
	if (!strlen($item)) continue;

	$ytid = (new \af\youtube($af, $db))->id($item);
	if (empty($ytid)) continue;

	$article = $db->rowId('pudl_article', 'youtube_id', $ytid);
	if (!empty($article)) continue;

	$youtube = $db->rowId('pudl_youtube', 'youtube_id', $ytid);
	if (empty($youtube)) (new \af\youtube($af, $db))->import($ytid);

	$db->insert('pudl_article', [
		'user_id'			=> 0,
		'article_type'		=> 'tutorial',
		'article_timestamp'	=> $db->time(),
		'article_title'		=> '',
		'article_text'		=> '',
		'youtube_id'		=> $ytid,
	]);
}

$af->ok();
