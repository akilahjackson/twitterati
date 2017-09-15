<?php

//welcome message for AFSCME 1072

require_once('twitter-api-php/TwitterAPIExchange.php');

$createmessageurl = 'https://api.twitter.com/1.1/statuses/update.json';
$requestMethod = 'POST';

//greenteam creds
$settings = array(
    'oauth_access_token' => "811975859070443523-s3idYBSPXlzDvhqk5JqRJWnOHeQzeqA",
    'oauth_access_token_secret' => "TmBiYjr26JBP2IZvtuDNEO15B0vZaDJSPCN9JFrr2hXg3",
    'consumer_key' => "lKa06EW2OGOOXAsTffccUEYU1",
    'consumer_secret' => "iLFJnZYfuMCH38Juum3orEAfX2QU4pMW4y5LAXlQgmfsd4uGFr"
);

$twitter = new TwitterAPIExchange($settings);


$mediaid = 908534122448080897;
$screen_name = "@akilah";

$postfields = array(
    'status' => 'D '. $screen_name.' We DO NOT have a thriving workplace. We are NOT the faces on marketing materials. We ARE the real people who staff the University of Maryland and we are bargaining on a new employee contract that affects wages, benefits, leave time and workers rights. Follow us on Twitter and Facebook to support University of Maryland employees and their families http://afscme1072.org/in-action', 
    'trim_user' => 'true',
    'media_ids' => $mediaid,
    'enable_dm_commands' => 'true'
    
    
);

$twitter = new TwitterAPIExchange($settings);
$response = $twitter->setPostfields($postfields)
    ->buildOauth($createmessageurl, $requestMethod)
    ->performRequest();
    
$mydata = json_decode($response,true);
 
 
 print_r($mydata);

?>