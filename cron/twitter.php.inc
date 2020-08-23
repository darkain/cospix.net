<?php
return;

////////////////////////////////////////////////////////////
//LOAD TWITTER API
////////////////////////////////////////////////////////////
require_once('_altaform/twitter.php.inc');
require_once('_twitter/TwitterAPIExchange.php');




////////////////////////////////////////////////////////////
//IMPORT NEW TWITTER ACCOUNTS
////////////////////////////////////////////////////////////
$rows = $db->rows('pudl_event', ['event_twitter'=>pudl::neq(NULL)]);
foreach ($rows as $row) if (!empty($row['event_twitter'])) {
	$twitter = $row['event_twitter'];
	if ($db->idExists('pudl_twitter_account', 'twitter_name', $twitter)) continue;

	$twitterapi = new TwitterAPIExchange(array(
		'oauth_access_token'		=> $afconfig->twitter['user_token'],
		'oauth_access_token_secret'	=> $afconfig->twitter['user_secret'],
		'consumer_key'				=> $afconfig->twitter['id'],
		'consumer_secret'			=> $afconfig->twitter['secret']
	));

	$twitterapi
		->setPostfields(array('screen_name' => $twitter))
		->buildOauth('https://api.twitter.com/1.1/friendships/create.json', 'POST')
		->performRequest();

	$twitterapi = new TwitterAPIExchange(array(
		'oauth_access_token'		=> $afconfig->twitter['user_token'],
		'oauth_access_token_secret'	=> $afconfig->twitter['user_secret'],
		'consumer_key'				=> $afconfig->twitter['id'],
		'consumer_secret'			=> $afconfig->twitter['secret']
	));

	$data = $twitterapi
		->setGetfield("screen_name=$twitter")
		->buildOauth('https://api.twitter.com/1.1/statuses/user_timeline.json', 'GET')
		->performRequest();

	if (empty($data)) continue;

	importTweets($data, array(
		'parent_id'		=> $db->selectRows('event_id', 'pudl_event', ['event_twitter'=>$twitter]),
		'parent_type'	=> 'event',
	));
}




////////////////////////////////////////////////////////////
//IMPORT NEW TWEETS
////////////////////////////////////////////////////////////
$last = $db->cell('pudl_twitter_data', 'MAX(tweet_id)');
if (!empty($last)) $last = "?since_id=$last";

$twitterapi = new TwitterAPIExchange(array(
	'oauth_access_token'		=> $afconfig->twitter['user_token'],
	'oauth_access_token_secret'	=> $afconfig->twitter['user_secret'],
	'consumer_key'				=> $afconfig->twitter['id'],
	'consumer_secret'			=> $afconfig->twitter['secret']
));

$data = $twitterapi
	->setGetfield($last)
	->buildOauth('https://api.twitter.com/1.1/statuses/home_timeline.json', 'GET')
	->performRequest();

if (empty($data)) return;


$data = json_decode($data);
if (empty($data)) return;

//TODO: put in a check here to see if TWITTER returned an error, if so, log it!

foreach ($data as &$tweet) {
	if (!is_object($tweet)) {
		echo 'ERROR LOADING TWITTER';
		break;
	}

	$handle = $tweet->user->screen_name;
	if ($handle == $afconfig->twitter['handle']) continue;

	importTweet($tweet, array(
		'parent_type'	=> 'event',
		'parent_id'		=> $db->selectRows(
			'event_id',
			'pudl_event',
			['event_twitter' => $handle]
		),
	));
} unset($tweet);
