<?php

//welcome message for AFSCME 1072

require_once('twitter-api-php/TwitterAPIExchange.php');

$createmessageurl = 'https://api.twitter.com/1.1/direct_messages/events/new.json';
//$welcomeurl = 'https://api.twitter.com/1.1/direct_messages/welcome_messages/new.json';
$requestMethod = 'POST';

//greenteam creds
$settings = array(
    'oauth_access_token' => "811975859070443523-s3idYBSPXlzDvhqk5JqRJWnOHeQzeqA",
    'oauth_access_token_secret' => "TmBiYjr26JBP2IZvtuDNEO15B0vZaDJSPCN9JFrr2hXg3",
    'consumer_key' => "lKa06EW2OGOOXAsTffccUEYU1",
    'consumer_secret' => "iLFJnZYfuMCH38Juum3orEAfX2QU4pMW4y5LAXlQgmfsd4uGFr"
);

$twitter = new TwitterAPIExchange($settings);

$myid = 9246732;
$sourceid = 811975859070443523;
///Postfields for initalizing the media upload
$postarray = array(
	
	'event'=> array (
			'type' =>'message_create',
			'message_create' => array (
				'target' => array (
					'recipient_id' => $myid
					
					),
					
					'sender_id' => $sourceid,
					
					'message_data' => array (
							'text' => 'HAHAHA!!! It\'s Alive',
							'attachment' => array (
									'type' => 'media',
										'media' => array (
											'id' => '907339344662466560'
						
						)
					)
							)
			
	)
	)
			
);
		
$postjson = json_encode($postarray)	;

echo "VAR DUMP of postjson". "\n\n";
var_dump($postjson);
echo "\n\n";

// create curl resource
$ch = curl_init();

// set url
curl_setopt($ch, CURLOPT_URL, $createmessageurl);

// set the HTTP header

curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/json', 'Content-Length: ' . strlen($postjson), 'Authorization: OAuth oauth_consumer_key="lKa06EW2OGOOXAsTffccUEYU1",oauth_token="811975859070443523-s3idYBSPXlzDvhqk5JqRJWnOHeQzeqA",oauth_signature_method="HMAC-SHA1",oauth_timestamp="1505147078",oauth_nonce="576LWZWukHP",oauth_version="1.0",oauth_signature="NcBLzj7Xr2s08%2BRqkhU8wUr4rVc%3D"'));

// set the location of the JSON file to post
//curl_setopt($ch, CURLOPT_POST, 1);
//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postjson);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

//return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// $output contains the output string

$output = curl_exec($ch);

echo $output ."\n\n";

// $status contains the HTTP response code
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$responseout = curl_getinfo($ch, CURLINFO_HEADER_OUT);

echo $status . "\n\n" ;

//close curl resource to free up system resources
curl_close($ch);



/*$response = $twitter ->buildOauth($createmessageurl, $requestMethod)
->setPostfields($postarray)
->performRequest();

$status = $twitter->getHttpStatusCode();

$request = json_decode($response, true);

echo "Let's check the status of that message : " . $status . "\n\n";

var_dump($response);

echo "\n\n";

vardump ($request); */



?>