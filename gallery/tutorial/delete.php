<?php
$user->requireLogin();


$gallery = $db->rowId('pudl_gallery', 'gallery_id', $get->id());
\af\affirm(404, $gallery, 'Invalid Gallery');
\af\affirm(401, $user->is($gallery));


$article = $db->rowId('pudl_article', 'article_id', $get->id('item'));
\af\affirm(404, $article, 'Invalid Article');
\af\affirm(422, $article['article_type'] === 'tutorial', 'Invalid Article Type');


$db->delete('pudl_gallery_tutorial', [
	'gallery_id' => $gallery['gallery_id'],
	'article_id' => $article['article_id'],
]);


$af->ok();
