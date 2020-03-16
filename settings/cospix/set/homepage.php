<?php

$user->update([
	'user_home' => $get('value') === 'discover' ? 'discover' : 'homepage'
]);
