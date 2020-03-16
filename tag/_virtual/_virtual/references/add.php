<?php
require_once('../tag.php.inc');
\af\affirm(401, $profile['edit']);

$af->renderField('references/add.tpl', 'tag', $group);
