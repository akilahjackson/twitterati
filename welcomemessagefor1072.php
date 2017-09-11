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

///Postfields for initalizing the media upload
$postarray = array(
	
	'event'=> array (
			'type' =>'message_create',
			'message_create' => array (
				'target' => array (
				'recipient_id' => $myid 
				)
			)
			
	),
			
	'message_data' => array (
			'text' => 'HAHAHA!!! It\'s Alive',
			'quick_reply.type' => 'I see want you did there...give me a second to respond',
			'attachment.type' => 'media',
			'atachment.media.id' => '907002000407179265'
			)
	
	);
		
$postjson = json_encode($postarray)	;

echo "VAR DUMP of postjson". "\n\n";
var_dump($postjson);
echo "\n\n";

$response = $twitter
->request($createmessageurl, $requestMethod, $postarray);

$status = $twitter->getHttpStatusCode();

$request = json_decode($response, true);

echo "Let's check the status of that message : " . $status . "\n\n";

var_dump($response);

echo "\n\n";

vardump ($request);



?>