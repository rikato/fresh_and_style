<?php
// API keys

$consumer_key = getWebsiteInfo('twitterConsumerKey', $dbcon);
$consumer_secret = getWebsiteInfo('twitterConsumerSecret', $dbcon);
$access_token = getWebsiteInfo('twitterAccesToken', $dbcon);
$access_token_secret = getWebsiteInfo('twitterAccesTokenSecret', $dbcon);


// Includes API libraries
require 'twitterapi/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

//Establish API connection
$connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
$content = $connection->get('account/verify_credentials');

//Load recent tweets
$tweets = $connection->get('statuses/home_timeline', ["count" => 3, "exclude_replies" => TRUE]);


function getTweets ($tweets){
    foreach ($tweets as $tweet) {
        //created date to time format
        $date = strtotime($tweet->created_at);
        //username of tweet
        echo '<div class="tweet">';
        echo '<div class="tweet-user"><a target="_blank" href="https://twitter.com/'.$tweet->user->screen_name.'">'.$tweet->user->name.'</a><span> @'.$tweet->user->screen_name.'</span></div>';
        //tweet text
        echo '<div class="tweet-text">'.$tweet->text.'</div>';
        //tweet date
        echo '<div class="tweet-date">'.date('d-m-Y h:i:s',$date).'</div>';
        echo '</div>';
    }
}

