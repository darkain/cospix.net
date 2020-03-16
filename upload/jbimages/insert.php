<?php

//TODO:	WE NEED TO PUSH THIS INFORMATION TO THE DATABASE
//		BUT IT IS RUNNING ON THE REMOTE SERVER...
//		ONCE WE MIGRATE TO THE DATACENTER, THIS WILL BE
//		MUCH EASIER!
$import	= new \af\import($af, $db);
$image	= $import->upload(false, false);


$af->load('insert.tpl');
	$af->field('result', [
		'filename'		=> !empty($image[800]['url']) ? $image[800]['url'] : $image['url'],
		'result'		=> 'file_uploaded',
		'resultcode'	=> 'ok',
	]);
$af->render();
