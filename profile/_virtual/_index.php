<?php
require_once('../types/types.php.inc');




////////////////////////////////////////////////////////////////////////////////
// WE'RE LOADING A LETTER, NOT A USER PROFILE
////////////////////////////////////////////////////////////////////////////////
if (preg_match('/^[a-z]$/', $router->virtual[0])) {
	return require('../letter.php.inc');
}




////////////////////////////////////////////////////////////////////////////////
// WE'RE LOADING A CATEGORY, NOT A USER PROFILE
////////////////////////////////////////////////////////////////////////////////
if (!empty($afusertypes[$router->part[2]])) {
	return require('../category.php.inc');
}




////////////////////////////////////////////////////////////////////////////////
// STYLES AND JS FOR FEED POSTING
////////////////////////////////////////////////////////////////////////////////
$af->script($afurl->static . '/js/underscore.js');
$af->script($afurl->static . '/js/jquery-textntags.js');
$af->style( $afurl->static . '/css/jquery-textntags.css');




////////////////////////////////////////////////////////////////////////////////
// LOAD UP ALL THE PROFILE GOODNESS
////////////////////////////////////////////////////////////////////////////////
require_once('profile.php.inc');

if (empty($profile['subpage'])) {
	require('profile/index.php.inc');
}




////////////////////////////////////////////////////////////////////////////////
// PULL SOCIAL LINKS FOR THE PAGE
////////////////////////////////////////////////////////////////////////////////
$render['social'] = $db->rowsId('pudl_user_social', 'user_id', $profile);

if (empty($render['social'])) $render['social'] = [];

foreach($render['social'] as &$item) {
	if (strpos($item['social_url'], '://') === false) {
		$item['social_url'] = 'http://' . $item['social_url'];
	}
} unset($item);




////////////////////////////////////////////////////////////////////////////////
// RENDER ALL THE THINGS
////////////////////////////////////////////////////////////////////////////////
$af->title = (!empty($af->title) ? $af->title.' - ' : '') . $profile['user_name'];

$prohome = false;

if (empty($afurl->jq)) {
	if ($af->prometheus()) {
		$prohome = true;
		$afurl->jq = 'profile/_prometheus.tpl';
	} else {
		$afurl->jq = 'profile/_index.tpl';
	}
}

$prometheus = false;
if ($af->prometheus()  &&  !empty($block)) {
	if (!empty($render[$block])  &&  $render[$block] instanceof pudlCollection) {
		$prometheus = true;
	}
}


if (!$prometheus) {

	if ($get->int('jq')) {
		if ($af->prometheus()) {
			$prohome = true;
			$af->load('profile/_prometheus.tpl');
		} else {
			$af->load('profile/_index.tpl');
		}
	} else if (!empty($profile->noheader)) {
		$af->header();
	} else {
		$af->header();
		$af->load($af->config->root.'/profile.tpl');
	}

	$af->block('actions',	$actions);
	$af->block('afproduct',	[]);

	if (!empty($render)) {
		if (!empty($block)  &&  !empty($render[$block])  &&  $render[$block] instanceof pudlCollection) {
			$render[$block]->prometheus();
		}
		$af->merge($render);
	}

	$af->render();


	if ($prohome) {
		$gallery = cpn_gallery::manage($db, $render['g']);
		$gallery->unshift(new cpn_custom($db, 'profile/gallery.tpl'));
		$gallery->unshift(new cpn_custom($db, 'profile/photos.tpl'));
		$gallery->render($af);
	}


	if (!$get->int('jq')) {
		$af->footer();
	}


} else {

	$af->header();
	$collection = $render[$block];
	unset($render[$block]);

	$af	->load('_cospix/profile_header.tpl')
		->block('actions',	$actions)
		->merge($render)
		->render();

	$collection->render($af);

	$af	->load('_cospix/profile_footer.tpl')
		->merge($render)
		->render();

	$af->footer();

}
