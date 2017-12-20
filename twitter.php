<?php

// API keys, these are needed for the API to work
$consumer_key = 'zNprlHSbbh7yGs0UvoZDppX2m';
$consumer_secret = '0gd42L8GaXdgxRIzSdxCMTLTIT64Zc7LpFJvkKmNDu633hEZ23';
$acces_token = '424120069-oAqxTnfGXAvieNIgORAOrQ7UN5R3TAebvaI0E0hA';
$acces_token_secret = '9FS0prkXdo5E03xjH16d1sXEH1nwGETJ9DHwEGOK2q1B1';

// Includes API libraries
require 'twitterapi/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

//Establishes API connection
$connection = new TwitterOAuth($consumer_key, $consumer_secret, $acces_token, $acces_token_secret);
$content = $connection->get('account/verify_credentials');

//Loads the  recent tweets, the count parameter sets how many tweets to load
$tweets = $connection->get('statuses/home_timeline', ["count" => 3, "exclude_replies" => TRUE]);

//Function that gets the tweets out of the array and makes them ready to be loaded on the page
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

