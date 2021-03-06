<?php
$user->requireLogin();




////////////////////////////////////////////////////////////
//PULL ARTICLE INFORMATION
////////////////////////////////////////////////////////////
$article = $db->rowId('pudl_article', 'article_id', $get->id());
\af\affirm(404, $article);
\af\affirm(401, $user->is($article));




////////////////////////////////////////////////////////////
//SWITCH TO ANONYMOUS ACCOUNT
////////////////////////////////////////////////////////////
$user = new afAnonymous($db);




////////////////////////////////////////////////////////////
//PROCESS INCOMING FILE
////////////////////////////////////////////////////////////
$import = new \af\import($af, $db);
$file	= $import->upload();




////////////////////////////////////////////////////////////
//UPDATE EVENT ICON
////////////////////////////////////////////////////////////
$db->updateId('pudl_article', [
	'article_icon' => $file['file_hash']
], 'article_id', $article);




////////////////////////////////////////////////////////////
//OUTPUT
////////////////////////////////////////////////////////////
$af->json($file);
