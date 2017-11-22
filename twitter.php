<?php

// API keys
$consumer_key = 'I0Fy0lmFHT1hx7rfH5RsXKUHj';
$consumer_secret = 'kEesiX5pGApIkQKjxLRkaMwga0ByOr5ymJYKVAMlovskY5Q69S';
$acces_token = '933252448998666240-j2doagiyKSBayGXKeWUdPxwHq0HaIFW';
$acces_token_secret = 'xNgjZq0auElWk1ZDZdN1KFetU9vxV5xYfeSz070WPrUQ1';

// Includes API libraries
require 'twitterapi/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

//Establish API connection
$connection = new TwitterOAuth($consumer_key, $consumer_secret, $acces_token, $acces_token_secret);
$content = $connection->get('acount/verify_credentials');

//Load recent tweets
$tweets = $connection->get('statuses/home_timeline', ["count" => 5, "exclude_replies" => TRUE]);

print_r($tweets);
