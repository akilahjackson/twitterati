<?php

require_once('twitter-api-php/TwitterAPIExchange.php');
$screen_name = "UofMaryland";

$settings = array(
    'oauth_access_token' => "811975859070443523-s3idYBSPXlzDvhqk5JqRJWnOHeQzeqA",
    'oauth_access_token_secret' => "TmBiYjr26JBP2IZvtuDNEO15B0vZaDJSPCN9JFrr2hXg3",
    'consumer_key' => "lKa06EW2OGOOXAsTffccUEYU1",
    'consumer_secret' => "iLFJnZYfuMCH38Juum3orEAfX2QU4pMW4y5LAXlQgmfsd4uGFr"
);


$url = 'https://api.twitter.com/1.1/followers/list.json';
$getfield = '?screen_name='.$screen_name.'&skip_status=true&include_user_entities=true&count=5000';
$requestMethod = 'GET';

$twitter = new TwitterAPIExchange($settings);
$response = $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();
    
$mydata = json_decode($response,true);


$previouscursor = "first_page";
$cursor = $mydata["next_cursor"];
$status = $twitter->getHttpStatusCode();

echo "You wanted" . " " . $screen_name . " ". "Followers from Twitter : " . "\n" ; 
echo $previouscursor ." ". "has printed". "\n";


do  {

if ($status = 429) {

echo "Rate Limit Execeed- 15 minute (900 seconds) countdown begins:" . "\n";

for($i = 900; $i > 0; $i--)
{
  echo $i;
  sleep(1);
  echo "\n"; 
}

echo "0\nThanksForYourPatience!";

}


$response = $twitter->setGetfield($getfield."&cursor=".$cursor)
    ->buildOauth($url, $requestMethod)
    ->performRequest();

$mydata = json_decode($response,true);

echo $cursor ." ". "has printed". " ". "with a response code of: ".$status."\n";


file_put_contents( $cursor.".json", serialize($mydata), FILE_APPEND) ; 
$cursor = $mydata["next_cursor"];


} while ($cursor != 0);


?>
