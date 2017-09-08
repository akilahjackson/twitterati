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

file_put_contents( $previouscursor.".json", serialize($mydata), FILE_APPEND) ; 


do  {


$cursor = $mydata["next_cursor"];	

$response = $twitter->setGetfield($getfield."&cursor=".$cursor)
    ->buildOauth($url, $requestMethod)
    ->performRequest();

$mydata = json_decode($response,true);

echo $cursor ." ". "has printed". " ". "with a response code of: ".$status."\n";


file_put_contents( $cursor.".json", serialize($mydata), FILE_APPEND) ; 


if ($cursor ==0) {

$applicationcheck = $twitter->buildOauth('https://api.twitter.com/1.1/application/rate_limit_status.json', $requestMethod)
->performRequest();

//echo print_r(json_decode($applicationcheck,true))."\n";

$applicationstatus = json_decode($applicationcheck,true);
		
print_r($applicationstatus["resources"]["followers"])."\n";


		 $resettime = $applicationstatus["resources"]["followers"]["/followers/list"]["remaining"];

	
		
		
		 echo "\n\n"."Script will reset at : ". unixtojd(($resettime)+($t%60*60*24)/60*60*24). "\n\n\n";	
	


echo "Rate Limit Execeed- 15 minute (900 seconds) countdown begins:" . "\n";

$n = 0;

	do {



		for($i = 905; $i > 0; $i--)
			{
			echo $i;
			sleep(1);
			echo " \\\\ "; 
			}

		echo "\n\n\n"."ThanksForYourPatience!"."\n\n";
		
		//$applicationstatus = json_decode($applicationcheck,true);
				$n++;
		
		echo "Number of Times the application has tried to re-run is : " . $n ."\n";
	} while($n ==1);
	
} 



} while ($cursor !=0);


?>
