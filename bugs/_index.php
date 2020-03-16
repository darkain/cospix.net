<?php

$af	->header()
		->load('_index.tpl')
			->block('bugs', [
				'date'			=> date('r'),
				'agent'			=> \af\device::agent(),
				'mode'			=> \af\device::device(),
				'theme'			=> $af->config->root,
				'user'			=> $user->id(),
				'url'			=> '_______________________',
				'error codes'	=> '_______________________',
				'problem'		=> '_______________________',
				'expected'		=> '_______________________',
				'result'		=> '_______________________',
			])
		->render()
	->footer();
