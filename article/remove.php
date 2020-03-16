<?php
$user->requireLogin();

$article = $db->rowId('pudl_article', 'article_id', $get->id());
\af\affirm(404, $article);
\af\affirm(401, $user->is($article));

$af->renderField('remove.tpl', 'article', $article);
