<?php

require_once('get.php.inc');

$update = ['user_bio' => $get->string('value')];

$db->updateId('pudl_user_profile', $update, 'user_id', $team['team_id']);

echo afString::linkify( $update['user_bio'] );
