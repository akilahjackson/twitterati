<?php

require_once('twitter-api-php/TwitterAPIExchange.php');
$screen_name = "";

$settings = array(
    'oauth_access_token' => "744587330770604033-NEWKzTFJjZAl2dL6NHiPSqFAeGjJKkX",
    'oauth_access_token_secret' => "DRrn2cPgzi8eRQaIQ6BxEBBKAK9ma8KKEvIXNqbs4YNPd",
    'consumer_key' => "utg6NwSJECCW6v1AEFHnTCM9f",
    'consumer_secret' => "KKZbR8GkFpcEsMo7paKbIFtDl4Tw1XP3lrS9WnJm5ybqgXZjpr"
);

//$restartcursor = 1565506688821987905;

$url = 'https://api.twitter.com/1.1/followers/list.json';
$getfield = '?screen_name='.$screen_name.'&skip_status=true&include_user_entities=true&count=5000';
$requestMethod = 'GET';

$twitter = new TwitterAPIExchange($settings);
$response = $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();
    
$mydata = json_decode($response,true);

$firstpage = "First_Page";
$previouscursor = $mydata["previous_cursor"];
$cursor = $mydata["next_cursor"];

$status = $twitter->getHttpStatusCode();

echo "You wanted" . " " . $screen_name . " ". "Followers from Twitter : " . "\n" ; 
echo $firstpage ." ". "has printed". "\n";

file_put_contents( "umuc/".$firstpage.".json", serialize($mydata), FILE_APPEND) ; 


do  {


$cursor = $mydata["next_cursor"];	

$response = $twitter->setGetfield($getfield."&cursor=".$cursor)
    ->buildOauth($url, $requestMethod)
    ->performRequest();

$mydata = json_decode($response,true);

echo $cursor ." ". "has printed". " ". "with a response code of: ".$status."\n";

file_put_contents( "umuc/".$cursor.".json", serialize($mydata), FILE_APPEND) ; 


$applicationcheck = $twitter->buildOauth('https://api.twitter.com/1.1/application/rate_limit_status.json', $requestMethod)
->performRequest();


$applicationstatus = json_decode($applicationcheck,true);
$appreset =$applicationstatus["resources"]["followers"]["/followers/list"]["reset"];
$appremaining = $applicationstatus["resources"]["followers"]["/followers/list"]["remaining"];

if ($appremaining <= 2) {


		
print_r($applicationstatus["resources"]["followers"])."\n\n";
	

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
