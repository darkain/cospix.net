<?php
$user->requireLogin();

$article = $db->rowId(['ar' => ['pudl_article',
	['left'=>['ev'=>'pudl_event'], 'using'=>'event_id'],
]],'article_id', $get->id());

\af\affirm(404, $article);
\af\affirm(401, $user->is($article));


//$af->script("$afurl->static/js/tiny.editor.packed.js");
//$af->style("$afurl->static/css/tinyeditor.css");
$af->script('//tinymce.cachefly.net/4.1/tinymce.min.js');

$af->header();

	$af->renderField('new/author.tpl', 'article', $article);

$af->footer();
