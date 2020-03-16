<?php

$user->requireLogin();

$gathering = $db->rowId('pudl_gathering', 'gathering_id', $get->id());
\af\affirm(404, $gathering);

$af->renderField('create.tpl', 'gathering', $gathering);
