<?php
$user->requireLogin();




////////////////////////////////////////////////////////////
//if updating existing article, make sure we have permissions!!
////////////////////////////////////////////////////////////
$id = $get->id();
if ($id > 0) {
	$article = $db->rowId('pudl_article', 'article_id', $id);
	\af\affirm(404, $article);
	\af\affirm(401, $user->is($article));
}




////////////////////////////////////////////////////////////
//Get and validate the article type!
////////////////////////////////////////////////////////////
$type = $get->string('type');
switch ($type) {
	case 'tutorial': break;
	case 'conreport': break;
	case 'productreview': break;
	default: $type = 'article';
}




////////////////////////////////////////////////////////////
//if con report, lets get the convention!
////////////////////////////////////////////////////////////
$event = $db->rowId('pudl_event', 'event_name', $get('convention'));
$event_id = empty($event) ? NULL : $event['event_id'];




////////////////////////////////////////////////////////////
//CLEAN AND VALIDATE HTML
////////////////////////////////////////////////////////////
require_once('_htmlawed/src/htmLawed/htmLawed.php');
require_once('filter.php.inc');


$text = $get->string('text', _GETVAR_BASIC);
$text = htmLawed($text, [
	'hook_tag'		=> 'lawedfilter',

	'abs_url'		=> 1,
	'base_url'		=> $afurl->host . $afurl->base,
	'cdata'			=> 1,
	'comment'		=> 1,
	'hexdec_entity'	=> 2,
	'tidy'			=> -1,
	'no_deprecated_attr' => 2,

	'schemes'		=> 'style: !; *:http, https, spdy',
	'elements'		=> 'a, b, blockquote, br, code, div, em, h1, h2, h3, h4, h5, h6, hr, i, img, li, ol, p, pre, s, span, strike, strong, sub, sup, table, tbody, td, tfoot, th, thead, tr, u, ul, wbr',
	'deny_attribute'=> '* -title -href -style -target -colspan -rowspan -alt -src',
]);

if (empty($text)) \af\error(422);




////////////////////////////////////////////////////////////
//UPDATE EXISTING ARTICLE
////////////////////////////////////////////////////////////
if ($id > 0) {
	$db->updateId('pudl_article', [
		'article_title'		=> $get->string('title'),
		'article_text'		=> $text,
		'article_type'		=> $type,
		'event_id'			=> $event_id,
	], 'article_id', $id);




////////////////////////////////////////////////////////////
//INSERT NEW ARTICLE
////////////////////////////////////////////////////////////
} else {
	$id = $db->insert('pudl_article', [
		'user_id'			=> $user['user_id'],
		'article_timestamp'	=> $db->time(),
		'article_title'		=> $get->string('title'),
		'article_text'		=> $text,
		'article_type'		=> $type,
		'event_id'			=> $event_id,
	]);


	//Activity!
	(new \af\activity($af, $user))->add($id, 'article', 'wrote a new');
}




////////////////////////////////////////////////////////////
//OUTPUT ALL THE THINGS
////////////////////////////////////////////////////////////
//TODO: change this over to proper redirect
echo "<script>document.location='$afurl->base/article/$id'</script>";
