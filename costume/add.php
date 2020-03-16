<?php
$user->requireLogin();




//TRANSACTIONS!!
$db->begin();


//CREATE NEW COSTUME
$id = $db->insert('pudl_gallery', [
	'gallery_type'		=> 'costume',
	'gallery_role'		=> 'cosplay',
	'user_id'			=> $user['user_id'],
	'gallery_timestamp'	=> $db->time(),
]);
\af\affirm(500, $id, 'Unable to create gallery object');



//UPDATE GALLERY SORT ORDER
$db->updateId('pudl_gallery',
	"gallery_sort=gallery_sort+1",
	'user_id', $user
);


//ACTIVITY!!!
(new \af\activity($af, $user))->add($id, 'gallery', 'added a new costume');


//TRANSACTIONS!!
$db->commit();


//TODO: CHANGE THIS TO A NORMAL REDIRECT
echo "<script>
history_ready = true;
History.pushState(null, null, '$afurl->base/$user[user_url]/costume/$id');
</script>";
