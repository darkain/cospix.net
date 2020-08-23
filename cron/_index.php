<?php

echo "CHECKING SQL CLUSTER STATUS\N";
require_once('mariadb.php.inc');

echo "PROCESSING QUEUE\n";
require_once('queue.php.inc');

echo "PROCESSING TWITTER\n";
require_once('twitter.php.inc');

echo "DELETING OLD TWITTER DATA\n";
$db->delete('pudl_twitter_data', 'tweet_time<'.($db->time()-(AF_DAY)));
