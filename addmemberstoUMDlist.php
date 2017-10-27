<?php
require_once('twitter-api-php/TwitterAPIExchange.php');

$url = 'https://api.twitter.com/1.1/lists/members/create_all.json';
$requestMethod = 'POST';

//greenteam creds
$settings = array(
    'oauth_access_token' => "811975859070443523-k07a581VEdTR4pDtU2uZXvolyzHdgrr",
    'oauth_access_token_secret' => "q66980At0lhw7IDLL967BaPOjjvZlTGHC7HcnXgZK0enO",
    'consumer_key' => "x0RbXp3aFgtiVOCCFBnsUFrRd",
    'consumer_secret' => "QBuQHxUjRrdMI0vQAYvfW5OPvbQ9WngvBfuD1yUfszWcYJIOqj"
);



$twitter = new TwitterAPIExchange($settings);

// File details
$filelocation = "uomaryland/";
$filename_array = array();

if (is_dir($filelocation)) 
{
	if ($handle = opendir($filelocation))
	{
	
		while(($file = readdir($handle)) !== FALSE)
		{
			$filename_array[] = $file;
		}
	
	closedir($handle);
	}
}

foreach($filename_array as $value) 
{
	
	echo $value . "\n\n";
	}

// Get contents of each file and return the screen_name



$j=201;

do {
		
	


$readfile = $filename_array[$j];



$datafromfile = file_get_contents("uomaryland/".$readfile,TRUE);
	
	$json = unserialize($datafromfile);
	
//print_r($json);
	

	$keystoarray = array_keys($json);
	
	for($i = 0; $i < (count($json)-4); $i++) {
		
		echo $keystoarray[$i] . "\n\n";
		
		foreach($json[$keystoarray[$i]] as $key => $value) {
			
			echo "Adding the following user to the list : " ."\n\n";
			print_r($json["users"][$key]["screen_name"]). "\n";
			echo "\n\n";
			
			/// UOMARYLAND list id
			$listid = 916358841327149061;

			
			$postfields = array(
				'list_id' =>$listid,
				'user_id' => $json["users"][$key]["id"],
				'screen_name' => $json["users"][$key]["screen_name"]
				);
			
				$response = $twitter->setPostfields($postfields)
					->buildOauth($url, $requestMethod)
					->performRequest();

				$status = $twitter->getHttpStatusCode();
				
				echo "........ User ID : " . $json["users"][$key]["id"] . "\n";
				echo "........ Status Check : " . $status . "\n\n";
			
		}
	}
	

		
$applicationcheck = $twitter->buildOauth('https://api.twitter.com/1.1/application/rate_limit_status.json', $requestMethod)
->performRequest();


$applicationstatus = json_decode($applicationcheck,true);
$appreset =$applicationstatus["resources"]["lists"]["/lists/members"]["reset"];
$appremaining = $applicationstatus["resources"]["lists"]["/lists/members"]["remaining"];

if ($appremaining <= 2) {
$j++;
		
print_r($applicationstatus["resources"])."\n\n";
	

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



} while($status !==429);



	?>