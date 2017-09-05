<?php

require_once('twitter-api-php/TwitterAPIExchange.php');
$search_term = "umd";
$page = 1;
$count = 1000;

$settings = array(
    'oauth_access_token' => "811975859070443523-s3idYBSPXlzDvhqk5JqRJWnOHeQzeqA",
    'oauth_access_token_secret' => "TmBiYjr26JBP2IZvtuDNEO15B0vZaDJSPCN9JFrr2hXg3",
    'consumer_key' => "lKa06EW2OGOOXAsTffccUEYU1",
    'consumer_secret' => "iLFJnZYfuMCH38Juum3orEAfX2QU4pMW4y5LAXlQgmfsd4uGFr"
);


$url = 'https://api.twitter.com/1.1/users/search.json';
$getfield = '?q='.$search_term.'&page='.$page.'&count='.$count;
$requestMethod = 'GET';

$twitter = new TwitterAPIExchange($settings);
$response = $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();
    
//$mydata = json_decode($response,true);


$status = $twitter->getHttpStatusCode();

echo "Your search term : " . " " . $search_term . " ". " results from Twitter : " . "\n" ; 
echo $search_term."-".$page." ". "has printed". " ". "with a response code of: ".$status."\n";



do  {

/*if ($status = 429) {

$applicationcheck = $twitter->buildOauth('https://api.twitter.com/1.1/application/rate_limit_status.json', $requestMethod)
->performRequest();

echo print_r(json_decode($applicationcheck,true))."\n";

echo "Rate Limit Execeed- 15 minute (900 seconds) countdown begins:" . "\n";

for($i = 900; $i > 0; $i--)
{
  echo $i;
  sleep(1);
  echo " \\\\ "; 
}

echo "0\nThanksForYourPatience!";

}*/


$page++;

$url = 'https://api.twitter.com/1.1/users/search.json';
$getfield = '?q='.$search_term.'&page='.$page.'&count='.$count;
$requestMethod = 'GET';

$twitter = new TwitterAPIExchange($settings);
$response = $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();


echo $search_term."-".$page." ". "has printed". " ". "with a response code of: ".$status."\n";


file_put_contents( $search_term."-".$page.".json", $response, FILE_APPEND);



} while ($page != 1000);


?>
