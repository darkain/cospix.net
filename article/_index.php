<?php
$af->title = 'Articles';


$af->header();
	$af->load('_index.tpl');

		$af->block('blog', $db->selectRows(
			'*',
			['ar'=>'pudl_article'],
			['article_type'=>'article'],
			['article_timestamp'=>pudl::dsc()],
			10
		));

		$af->block('tutorial', $db->selectRows(
			'*',
			[
				'ar'=>['pudl_article',
					['left'=>'pudl_youtube', 'using'=>'youtube_id']
				]
			],
			['article_type'=>'tutorial'],
			['article_timestamp'=>pudl::dsc()],
			10
		));

		$af->block('report', $db->selectRows(
			'*',
			['ar'=>'pudl_article'],
			['article_type'=>'conreport'],
			['article_timestamp'=>pudl::dsc()],
			10
		));

		$af->block('review', $db->selectRows(
			'*',
			['ar'=>'pudl_article'],
			['article_type'=>'productreview'],
			['article_timestamp'=>pudl::dsc()],
			10
		));

	$af->render();
$af->footer();
