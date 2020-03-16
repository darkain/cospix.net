<?php


////////////////////////////////////////////////////////////////////////////////
//PULL BADGE DATA
////////////////////////////////////////////////////////////////////////////////
\af\affirm(404,
	$badge = $db->rowId('pudl_badge', 'badge_id', $router->id)
);

$af->title = $badge['badge_name'];




////////////////////////////////////////////////////////////////////////////////
//PULL ALL OTHER BADGES WITHIN THE SAME GROUP
////////////////////////////////////////////////////////////////////////////////
$badges = [];
if (!empty($badge['badge_group'])) {
	$badges = $db->rows('pudl_badge', [
		'badge_group'	=> $badge['badge_group'],
		'badge_id'		=> pudl::neq($badge['badge_id']),
	], [
		'badge_sort',
		'badge_id',
	]);
}




////////////////////////////////////////////////////////////////////////////////
//PULL ALL USERS WHO HAVE THIS BADGE
////////////////////////////////////////////////////////////////////////////////
$users = new cpn_collection($db, 'cpn_user',
	$db->rows(
		['us'=>_pudl_user(200)+[
			['natural'	=> 'pudl_user_badge'],
			['natural'	=> 'pudl_user_profile'],
		]], [
			'badge_id'	=> $badge['badge_id'],
			'user_icon'	=> pudl::neq(NULL),
			cpnFilterBanned()
		], [
			'badge_timestamp'=>pudl::dsc(),
			'us.user_id',
		]
	)
);

$users->prometheus();




////////////////////////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS!!
////////////////////////////////////////////////////////////////////////////////
$af	->header()
		->load('_virtual.tpl')
			->field('badge',	$badge)
			->block('badges',	$badges)
			->block('users',	$af->prometheus() ? [] : $users)
		->render();

	if ($af->prometheus()) {
		$users->render($af);
	}

$af	->footer();
