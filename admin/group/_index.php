<?php

$af->header();
$af->renderBlock('_index.tpl', 'group', $db->rows('pudl_group_type'));
$af->footer();
