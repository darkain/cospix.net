<?php

$invites = $db->selectRows(
	[
		'iv.*',
		'us.*',
		'ir.user_name AS accept_name',
		'bg.*',
	], [
		'iv' => ['pudl_invite',
			[
				'left'	=> ['ir'=>'pudl_user'],
				'on'	=> 'ir.user_id=iv.invite_receiver'
			], [
				'left'	=> ['bg'=>'pudl_badge'],
				'on'	=> 'bg.badge_id=iv.invite_badge'
			],
		],
		'us' => 'pudl_user',
	],
	'iv.invite_sender=us.user_id',
	['invite_created'=>pudl::dsc()]
);


foreach ($invites as &$invite) {
	$invite['code'] = strtoupper(bin2hex($invite['invite_code']));
} unset($invite);



$af->script($afurl->static . '/js/jquery.dataTables.min.js');
$af->style( $afurl->static . '/css/jquery.dataTables.css');


$af->header();
	$af->renderBlock('_index.tpl', 'invites', $invites);
$af->footer();
