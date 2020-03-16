<?php
$user->requireLogin();

//$af->script("$afurl->static/js/tiny.editor.packed.js");
//$af->style("$afurl->static/css/tinyeditor.css");
$af->script('//tinymce.cachefly.net/4.1/tinymce.min.js');


//Get and validate the article type!
$type = $get->string('type');
switch ($type) {
	case 'tutorial': break;
	case 'conreport': break;
	case 'productreview': break;
	default: $type = 'article';
}


$af->header();

	$af->renderField('author.tpl', 'article', array(
		'article_id'		=> 0,
		'user_id'			=> 0,
		'article_type'		=> $type,
		'article_timestamp'	=> 0,
		'article_title'		=> '',
		'article_text'		=> '',
		'event_name'		=> '',
	));

$af->footer();
