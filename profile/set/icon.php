<?php

$user->requireLogin();




////////////////////////////////////////////////////////////////////////////////
//PROCESS INCOMING FILE
////////////////////////////////////////////////////////////////////////////////
$import	= new \af\import($af, $db);
$file	= $import->upload();




////////////////////////////////////////////////////////////////////////////////
//UPDATE USER ICON
////////////////////////////////////////////////////////////////////////////////
$user->update( ['user_icon' => $file['file_hash']] );




////////////////////////////////////////////////////////////////////////////////
//OUTPUT
////////////////////////////////////////////////////////////////////////////////
$af->json($file);
