<?php
$user->requireLogin();

$user->profile( ['user_tagline' => $get->string('text')] );

echo $get->string('text');
