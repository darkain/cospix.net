<?php
$user->requireStaff();

$update = ['group_label_text' => $get->string('text')];
$db->updateId('pudl_group_label', $update, 'group_label_id', $get->id());

echo afString::linkify( $update['group_label_text'] );
