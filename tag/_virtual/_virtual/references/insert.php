<?php
require_once('../tag.php.inc');
\af\affirm(401, $profile['edit']);


$name = $get->string('name');
\af\affirm(422, $name, 'Invalid gallery name');


//TODO: BUILD A LIST OF NON-ACCEPTABLE CHARACTERS TO BLOCK IN NAMES

$db->begin();




////////////////////////////////////////////////////////////
//CREATE NEW GALLERY
////////////////////////////////////////////////////////////
$id = $db->insert('pudl_gallery', [
	'gallery_type'		=> 'gallery',
	'gallery_role'		=> 'photo',
	'gallery_timestamp'	=> $db->time(),
	'gallery_name'		=> $name,
	'group_id'			=> $group['group_id'],
]);

\af\affirm(422, $id, 'Unable to create gallery');




////////////////////////////////////////////////////////////
//UPDATE GALLERY SORT ORDER
////////////////////////////////////////////////////////////
$db->updateId('pudl_gallery',
	"gallery_sort=gallery_sort+1",
	'group_id', $group
);




////////////////////////////////////////////////////////////
//OUTPUT THE URL
////////////////////////////////////////////////////////////
$db->commit();
echo "$afurl->base/tag/$group[group_type_name]/"
	. $afurl->clean($group['group_label'])
	. "/references/$id";
