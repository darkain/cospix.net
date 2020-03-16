<?php

if ($af->device() === 'desktop')	\af\device::redetect();
if ($af->device() === 'mobile')		\af\device::set('tablet');

$af->renderPage('_index.tpl');
