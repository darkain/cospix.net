<?php
$user->requireLogin();

$update = ['user_bio' => $get->string('value')];

$db->updateId('pudl_user_profile', $update, 'user_id', $get->id());

echo afString::linkify( $update['user_bio'] );
