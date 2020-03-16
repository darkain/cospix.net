<?php

$af->renderPage('_index.tpl', [
	'badge' => $db->rows('pudl_badge')
]);
