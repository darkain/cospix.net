<?php
$user->requireLogin();


$article = $db->rowId('pudl_article', 'article_id', $get->id());
\af\affirm(404, $article);
\af\affirm(401, $user->is($article));


//Get and validate the article type!
$type = $get->string('type');
switch ($type) {
	case 'tutorial': break;
	case 'conreport': break;
	case 'productreview': break;
	default: $type = 'article';
}


$db->updateId('pudl_article', [
	'article_type' => $type,
], 'article_id', $article);


$afurl->redirect("$afurl->base/article/$article[article_id]");
