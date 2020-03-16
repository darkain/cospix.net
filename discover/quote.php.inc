<?php


$quote = $db->row(
	[['pudl_positive_quote', ['left'=>'pudl_user', 'using'=>'user_id']]],
	false,
	pudl::rand()
);


if (!empty($quote['user_name'])) {
	$quote['quote_author'] = $quote['user_name'];
}


/*
array (
  'user_id' => NULL,
  'quote_id' => '65',
  'quote_author' => 'Joel Guttman',
  'quote_text' => 'Keep moving forward.',
  'quote_timestamp' => '1445588450',
  'user_permission' => NULL,
  'user_name' => NULL,
  'user_url' => NULL,
  'user_icon' => NULL,
  'user_adfree' => NULL,
  'user_type' => NULL,
)
*/
