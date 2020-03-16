<?php

require_once('event.php.inc');
//require_once('_cospix/calendar.php.inc'); //required for gatherings
require_once('_cospix/products.php.inc');


require('event/index.php.inc');



////////////////////////////////////////////////////////////////////////////////
//PRODUCTS
////////////////////////////////////////////////////////////////////////////////
$products = (new cpnProduct($af, $db))->suggest();
array_splice($products, 4);




////////////////////////////////////////////////////////////////////////////////
//BUILD MENU DATA
////////////////////////////////////////////////////////////////////////////////
$menu = [
	'Admin'			=> $profile['edit'],
	'Schedule'		=> $db->idExists('pudl_schedule_room', 'event_id', $event),
	'Feed'			=> $user->isAdmin(),
	'Map'			=> 1,
	'Checklists'	=> 0,//$user->loggedIn(),
	'Discussion'	=> 0,
	'Gatherings'	=> 0,
	'Costumes'		=> $db->idExists('pudl_gallery_event', 'event_id', $event),
	'Gallery'		=> $db->idExists('pudl_gallery', 'event_id', $event),
	'Photos'		=> 1,
	'Attendees'		=> $db->idExists('pudl_user_event', 'event_id', $event),
	'Reports'		=> 0,//$db->idExists('pudl_article', 'event_id', $event),
];




////////////////////////////////////////////////////////////////////////////////
//BUILD ADMIN MENU DATA
////////////////////////////////////////////////////////////////////////////////
$admin = [];
if ($profile['edit']) {
	$admin = [
		[
			'text'	=> 'Edit Social Links',
			'click'	=> $afurl([$profile['type'], 'links'],1) . "?id=$profile[id]"
		], [
			'text'	=> 'Add Next Event',
			'href'	=> $afurl([$profile['type'], 'new'],1)  . "?id=$profile[id]&dir=next"
		], [
			'text'	=> 'Add Previous Event',
			'href'	=> $afurl([$profile['type'], 'new'],1)  . "?id=$profile[id]&dir=prev"
		],
	];
}




////////////////////////////////////////////////////////////////////////////////
// OPENGRAPH DATA
////////////////////////////////////////////////////////////////////////////////
$af->title = (empty($af->title) ? '' : $af->title . ' - ') . $event['event_name'];
$event['event_pic_url'] = $afurl->cdn($event, 'file_hash');
if (empty($event['event_pic_url'])) $event['event_pic_url'] = $afurl->cdn($event, 'thumb_hash');
if (empty($event['event_pic_url'])) $event['event_pic_url'] = $afurl->cdn($event, 'event_icon');

if (empty($og['description'])) {
	$og['description']  = "$event[event_name] at $event[event_venue] in $event[event_location] on "
		. \af\time::daterange($event['event_start'], $event['event_end']);
} else {
	$og['description'] .= "$event[event_name] at $event[event_venue] in $event[event_location] on "
		. \af\time::daterange($event['event_start'], $event['event_end']);
}

$af->metas([
	['name'=>'twitter:card',		'content'=>'summary'],
	['name'=>'twitter:site',		'content'=>'@cospixnet'],
	['name'=>'twitter:domain',		'content'=>'Cospix.net'],
	['name'=>'twitter:title',		'content'=>$event['event_name'] . ' - ' . $og['title']],
	['name'=>'twitter:description',	'content'=>$og['description']],
]);

if (!empty($event['event_pic_url'])) {
	$og['image'] = $event['event_pic_url'];
	$af->meta(['name'=>'twitter:image', 'content'=>$og['image']]);
}

if (!empty($event['event_twitter'])) {
	$af->meta(['name'=>'twitter:creator', 'content'=>"@$event[event_twitter]"]);
}




////////////////////////////////////////////////////////////////////////////////
//PULL SOCIAL LINKS FOR THE PAGE
////////////////////////////////////////////////////////////////////////////////
$social = $db->rowsId('pudl_event_social', 'event_id', $event);

if (!empty($event['event_twitter'])) {
	array_unshift($social, [
		'social_type'	=> 'Twitter',
		'social_url'	=> "https://twitter.com/$event[event_twitter]",
	]);
}

if (!empty($event['event_website'])) {
	array_unshift($social, [
		'social_type'	=> 'Home',
		'social_url'	=> $event['event_website'],
	]);
}




////////////////////////////////////////////////////////////////////////////////
//RENDER ALL THE THINGS
////////////////////////////////////////////////////////////////////////////////
$prohome = false;

if (empty($afurl->jq)) {
	if ($af->prometheus()) {
		$prohome = true;
		$afurl->jq = 'event/_prometheus.tpl';
	} else {
		$afurl->jq = 'event/_index.tpl';
	}
}

$prometheus = false;
if ($af->prometheus()  &&  !empty($block)) {
	if (!empty($render[$block])  &&  $render[$block] instanceof pudlCollection) {
		$prometheus = true;
	}
}

$af->script('https://maps.googleapis.com/maps/api/js?libraries=places&amp;v=3.exp&amp;key=AIzaSyAn5Za48Zs6ydKZ5YnHdvpfNcJVsKFM-Xc&amp;sensor=false');

$af->script('/static/altaform/af-map.js');

if (!$prometheus) {

	if ($get->int('jq')) {
		$af->load($afurl->jq);
	} else {
		$af->header();
		$af->load($af->config['root'].'/profile.tpl');
	}

	$af->field('event',		$event);
	$af->field('profile',	$profile);
	$af->block('actions',	$actions);
	$af->block('menu',		$menu);
	$af->block('admin',		$admin);
	$af->block('social',	$social);
	$af->block('afproduct',	$products);

	if (!empty($render)) $af->merge($render);

	if (!empty($render)) {
		if (!empty($block)  &&  !empty($render[$block])  &&  $render[$block] instanceof pudlCollection) {
			$render[$block]->prometheus();
		}
		$af->merge($render);
	}

	$af->render();

	if ($prohome) {
		$eventlist = cpn_event::manage($db, $render['eventlist']);
		$eventlist->each(function($item){
			$item['link_name']	= $item['event_name'];
			$item['name']		= \af\time::daterange($item['event_start'], $item['event_end']);
		});
		$eventlist->render($af);
	}

	if (!$get->int('jq')) {
		$af->footer();
	}

} else {

	$af->header();
	$collection = $render[$block];
	unset($render[$block]);

	$af	->load('_cospix/profile_header.tpl')
		->field('profile',	$profile)
		->block('actions',	$actions)
		->block('admin',	$admin)
		->block('social',	$social)
		->merge($render)
		->render();

	$collection->render($af);

	$af	->load('_cospix/profile_footer.tpl')
		->field('profile',	$profile)
		->merge($render)
		->render();

	$af->footer();

}
