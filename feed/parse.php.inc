<?php

function parse_feed(&$item) {
	global $af, $db, $afurl;

	$item['since']		= \af\time::since($item['activity_timestamp']);
	$item['url']		= $afurl->cdn($item, 'thumb_hash');
	$item['recommend']	= [];

	switch ($af->type($item['object_type_id'])) {


		case 'gallery':
			$rows = $db->selectRows(
				'*',
				['ga'=>'pudl_gallery', 'gi'=>_pudl_gallery_image(150)],
				['ga.gallery_id'=>$item['object_id'], 'ga.gallery_id=gi.gallery_id'],
				['image_time'=>pudl::dsc()],
				$item['style']==='feed' ? 6 : 5
			);

			if (empty($rows)) return false;

			$row = reset($rows);

			$item = array_merge($item, $row);
			$item['name'] = &$item['gallery_name'];

			$item['link']  = '/' . (empty($item['user_url']) ? $item['user_id'] : $item['user_url']);
			$item['link'] .= '/' . $item['gallery_type'] . '/' . $item['object_id'];

			$af->load('feed/gallery.tpl')->block('gallery', $rows);
			$item['template'] = $af->renderToString();

			//TAGS
			$list = cpnTag::getObject($item);
			if ($list->hasRows()) parse_feed_recommended($item, $list);
			$list->free();

			//COMMENTS
			parse_feed_comments($item);
		break;



		//TODO: CHANGE ALL EXISTING "EVENT" FEED ITEMS TO "ATTENDING"
		case 'event':
			$row = $db->rowId(['ev' => _pudl_event(100)], 'event_id', $item['object_id']);

			if (empty($row)) return false;

			$row['range'] = \af\time::daterange($row['event_start'], $row['event_end']);

			$item = array_merge($item, $row);
			$item['name'] = &$item['event_name'];
			$item['link'] = '/event/' . $afurl->clean($item['event_name']);

			$af->load('feed/event.tpl');
			$af->field('event', $row);
			$item['template'] = $af->renderToString();

			//TAGS
			$list = cpnTag::getObject($item);
			if ($list->hasRows()) parse_feed_recommended($item, $list);
			$list->free();

			//COMMENTS
			$item['object_type_id'] = $af->type('attending');
			parse_feed_comments($item);
		break;



		case 'answer':
			$row = $db->selectRow(
				['ak.*', 'text'=>'ak.question_text', 'sender_name'=>'us.user_name', 'th.*'],
				['ak'=>'pudl_ask', 'us'=>_pudl_user(100)],
				['ask_id'=>$item['object_id'], 'ak.sender_id=us.user_id', cpnFilterBanned()]
			);
			if (empty($row)) return false;

			$item = array_merge($item, $row);

			$item['link'] = "$afurl->base/ask/$item[object_id]";
			$item['name'] = 'answered ' . $item['sender_name'] . '\'s question';
			$item['activity_verb'] = '';
		break;



		case 'article':
			$row = $db->selectRow(
				['*'],
				['ar'=>'pudl_article', 'us'=>_pudl_user(100)],
				[
					'article_id' => $item['object_id'],
					'ar.user_id=us.user_id',
					cpnFilterBanned(),
				]
			);

			if (empty($row)) return false;

			$item = array_merge($item, $row);

			$item['link'] = "$afurl->base/article/$item[object_id]";
			$item['name'] = $row['article_title'];
			$item['activity_verb'] .= ' ' . $row['article_type'];

			//TAGS
			$list = cpnTag::getObject($item);
			if ($list->hasRows()) parse_feed_recommended($item, $list);
			$list->free();

			//COMMENTS
			parse_feed_comments($item);
		break;



		case 'badge':
			$badge				= $db->row([
				'bg' => 'pudl_badge',
				'ub' => 'pudl_user_badge'
			], [
				'ub.badge_id=bg.badge_id',
				'ub.badge_id'	=> $item['object_id'],
				'ub.user_id'	=> $item['user_id']
			]);

			if (empty($badge)) return false;

			$item['name']		= $badge['badge_name'] . ' Badge';
			$item['link']		= $afurl->base . '/badge/' . $badge['badge_id'];

			$af->load('feed/badge.tpl')->field('b', $badge);
			$item['template']	= $af->renderToString();
		break;



		case 'activity':
			$item['name']		= '';
			$item['link']		= '';
			$item['template']	= afString::linkify($item['activity_text']);

			//TAGS
			$list = cpnTag::getObject($item);
			if ($list->hasRows()) parse_feed_recommended($item, $list);
			$list->free();

			//COMMENTS
			parse_feed_comments($item);
		break;



		case 'featured':
			$image = $db->cache(60)->row([
				//YES, WE WANT EIGHT-HUNDRED SIZE FOR THIS PAGE
				'fe' => _pudl_feature(800),
				'gi' => 'pudl_gallery_image',
				'ga' => 'pudl_gallery',
			], [
				'fe.file_hash'	=> $item['file_hash'],
				'ga.user_id'	=> $item['user_id'],
				'gi.gallery_id=ga.gallery_id',
				'fe.file_hash=gi.file_hash',
			]);

			if (empty($image)) return false;

			$image['url']		= $afurl->cdn($image['thumb_hash']);
			$item['name']		= 'Photo of the Day';
			$item['link']		= $afurl->base . '/featured';
			$item['extra_text']	= 'for ' . date('F jS', $image['feature_timestamp']);

			$af->load('feed/image.tpl')->field('feed',$item)->field('image',$image);
			$item['template']	= $af->renderToString();

			//TAGS
			$list = cpnTag::getFileImage($item['file_hash']);
			if ($list->hasRows()) parse_feed_recommended($item, $list);
			$list->free();

			//COMMENTS
			$item['object_type_id'] = $af->type('image');
			parse_feed_comments($item, true);
		break;



		default:
			$item['object_id']	= 0;
			$item['name']		= '';
			$item['link']		= '';
			$item['template']	= afString::linkify($item['activity_text']);
	}

	return true;
}



/////////////////////////////////////////////
// COMMENTS
/////////////////////////////////////////////
function parse_feed_comments(&$item, $hash=false) {
	global $af, $afurl, $db;

	if ($hash) {
		$clause = ['cm.file_hash'	=> $item['file_hash']];
	} else {
		$clause = ['cm.object_id'	=> $item['object_id']];
	}

	$comments = $db->cache(60)->rows(
		['us'=>_pudl_user(50), 'cm'=>'pudl_comment'],
		$clause+[
			'cm.commenter_id=us.user_id',
			'cm.object_type_id'		=> $item['object_type_id'],
			cpnFilterBanned(),
		],
		'comment_timestamp'
	);

	foreach ($comments as &$comment) {
		$comment['timesince'] = \af\time::since( $comment['comment_timestamp'] );
	} unset($comment);

	$afurl->cdnAll($comments, 'img', 'thumb_hash');

	$af->load('feed/comments.tpl');

	$af->block('comment', $comments);

	$af->field('newcomm', [
		'id'	=> $hash ? bin2hex($item['file_hash']) : $item['object_id'],
		'type'	=> $af->type($item['object_type_id']),
		'login' => 0,
	]);

	$item['comments'] = $af->renderToString();

	//TODO: standardize 'newcomm' so we can simply pass $item to it instead of building a new array
}



function parse_feed_recommended(&$item, $list) {
	global $afurl;

	if (!empty($list)) {
		$item['recommend'] = $list->rows();
	} else {
		$item['recommend'] = [];
	}

	$afurl->cdnAll($item['recommend'], 'img', 'thumb_hash');
}
