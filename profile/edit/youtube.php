<?php
$user->requireLogin();

$profile = $db->rowId('pudl_user_profile', 'user_id', $user['user_id']);

$youtube = $db->rowId('pudl_youtube', 'youtube_id', $profile['youtube_id']);

$af->load('youtube.tpl');
	$af->field('profile', $profile);
	$af->field('youtube', $youtube);
$af->render();
