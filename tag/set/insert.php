<?php
$user->requireStaff();

\af\affirm(422, $get('text'));
\af\affirm(422, $get('type'));

if (cpnTag::insertLabel($get('text'), $get('type')) === false) {
	\af\error(422, 'Error creating TAG object');
}

echo $get('text');
