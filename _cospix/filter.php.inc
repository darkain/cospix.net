<?php


////////////////////////////////////////////////////////////
//FILTER DEACTIVATED AND BANNED USERS
////////////////////////////////////////////////////////////
function cpnFilterBanned($prefixed=true) {
	if (!$prefixed) {
		return ['user_permission' => [4,5]];
	}

	if ($prefixed === true) $prefixed = 'us';

	return [$prefixed.'.user_permission' => [4, 5]];
}




////////////////////////////////////////////////////////////
//FILTER DIFFERENT USER TYPES BASED ON SKILL SETS
////////////////////////////////////////////////////////////
function cpnFilterUserType() {
	global $get;

	switch ($get->string('filter')) {
		case 'cosplayers': return [
			pudl::find('user_type', [
				'cosplay-male',
				'cosplay-female',
				'cosplay-other',
			]),
		];

		case 'photographers': return [
			pudl::find('user_type', [
				'photo-event',
				'photo-shoot',
			]),
		];

		case 'videographers': return [
			pudl::find('user_type', [
				'video-coverage',
				'video-interview',
				'video-music',
			]),
		];

		case 'commissioners': return [
			pudl::find('user_type', [
				'commission-general',
				'commission-wig',
				'commission-seamstress',
				'commission-props',
				'commission-casting',
				'commission-armor',
				'commission-accessories',
			]),
		];
	}

	unset($_GET['filter']);
	return '';
}



////////////////////////////////////////////////////////////
//FILTER CANCELED EVENTS
////////////////////////////////////////////////////////////
function cpnFilterCanceled() {
	return pudl::notFind('event_details', 'canceled');
}
