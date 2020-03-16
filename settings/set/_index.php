<?php

$name = $get->string('name');

if (empty($name)) \af\error(422);
if (!preg_match('/^[a-z_]*$/i', $name)) \af\error(422);

$user->updatePreference($name, $get->bool('value'));
