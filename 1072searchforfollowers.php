<?php

require_once('twitter-api-php/TwitterAPIExchange.php');
$querystring = "afscme";

$settings = array(
    'oauth_access_token' => "811975859070443523-s3idYBSPXlzDvhqk5JqRJWnOHeQzeqA",
    'oauth_access_token_secret' => "TmBiYjr26JBP2IZvtuDNEO15B0vZaDJSPCN9JFrr2hXg3",
    'consumer_key' => "lKa06EW2OGOOXAsTffccUEYU1",
    'consumer_secret' => "iLFJnZYfuMCH38Juum3orEAfX2QU4pMW4y5LAXlQgmfsd4uGFr"
);

$url = 'https://api.twitter.com/1.1/users/search.json';
$getfield = '?q='.$querystring.'&include_user_entities=true&count=5000';
$requestMethod = 'GET';

$twitter = new TwitterAPIExchange($settings);
$response = $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();
    
$mydata = json_decode($response,true);


$page = 1;

$status = $twitter->getHttpStatusCode();

echo "You wanted" . " " . $querystring . " ". "Followers from Twitter : " . "\n" ; 
echo $querystring." - ".$page ." ". "has printed". "\n";

file_put_contents( "afscme/".$querystring."-".$page.".json", serialize($mydata), FILE_APPEND) ; 


do  {

$page++;
$response = $twitter->setGetfield($getfield."&page=".$page)
    ->buildOauth($url, $requestMethod)
    ->performRequest();

$mydata = json_decode($response,true);

echo $querystring." - ".$page ." ". "has printed". " ". "with a response code of: ".$status."\n";

file_put_contents( "afscme/".$querystring."-".$page.".json", serialize($mydata), FILE_APPEND) ; 


$applicationcheck = $twitter->buildOauth('https://api.twitter.com/1.1/application/rate_limit_status.json', $requestMethod)
->performRequest();


$applicationstatus = json_decode($applicationcheck,true);
$appreset =$applicationstatus["resources"]["users"]["/users/search"]["reset"];
$appremaining = $applicationstatus["resources"]["users"]["/users/search"]["remaining"];

if ($appremaining <= 2) {


		
print_r($applicationstatus["resources"]["users"]["/users/search"])."\n\n";
	

echo "Rate Limit Execeed- 15 minute (900 seconds) countdown begins:" . "\n\n";

$n = 0;


	if ($n<2) {


	
		for($i = 901; $i > 0; $i--)
			{
			echo $i;
			sleep(1);
			echo " \\\\ "; 
			}

		echo "\n\n\n"."Thanks For Your Patience!"."\n\n";
		
		echo "\n\n\n"."The Reset Time for Your App is ".$appreset."\n\n";
		echo "\n\n\n"."The Remaining Calls before the next reset is ".$appremaining--."\n\n";
		
				$n++;
		
		echo "Number of Times the application has tried to re-run is : " . $n ."\n\n";		
		 
	continue;
	}

}



} while ($status != 429);

?>
