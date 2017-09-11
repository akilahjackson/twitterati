<?php
require_once('twitter-api-php/TwitterAPIExchange.php');

$url = 'https://upload.twitter.com/1.1/media/upload.json';
$requestMethod = 'POST';

//greenteam creds
$settings = array(
    'oauth_access_token' => "811975859070443523-s3idYBSPXlzDvhqk5JqRJWnOHeQzeqA",
    'oauth_access_token_secret' => "TmBiYjr26JBP2IZvtuDNEO15B0vZaDJSPCN9JFrr2hXg3",
    'consumer_key' => "lKa06EW2OGOOXAsTffccUEYU1",
    'consumer_secret' => "iLFJnZYfuMCH38Juum3orEAfX2QU4pMW4y5LAXlQgmfsd4uGFr"
);

$twitter = new TwitterAPIExchange($settings);

// File details
$nameoffile = "animatedpoliticalposterAfscme2.gif";
$filelocation = "media/";
$file = file_get_contents($filelocation."/".$nameoffile);
$base64_file = base64_encode($file);
$mimetype = mime_content_type ($filelocation."/".$nameoffile);
$totalbytes = filesize($filelocation."/".$nameoffile);

///Postfields for initalizing the media upload
$initpostfields = array(
		'command' => 'INIT',
		'media_type' => $mimetype,
		'total_bytes' => $totalbytes,
		'additional_owners'=>'9246732,744587330770604033',
		'media_category' => 'dm_gif',
		'shared'=>'TRUE'
		);
		
$initresponse = $twitter->setPostfields($initpostfields)
    ->buildOauth($url, $requestMethod)
    ->performRequest();

$status = $twitter->getHttpStatusCode();

$initrequest = json_decode($initresponse, true);

echo "Initializing media file........" .$status."\n\n";

print_r($initrequest);

file_put_contents( $nameoffile.".json", serialize($initrequest), FILE_APPEND);

echo "Printing log of request ........" .$status."\n\n";

$media_id = $initrequest["media_id"];

//Postfields for Appending File to media after initializing

$appendpostfields = array (
		'command' => 'APPEND',
		'media_id' => $media_id,
		'segment_index' => '0',
		'media_data' => $base64_file
		
		);

$appendresponse = $twitter->setPostfields($appendpostfields)
    ->buildOauth($url, $requestMethod)
    ->performRequest();
    
$status = $twitter->getHttpStatusCode();

$appendrequest = json_decode($appendresponse, true);

echo "Appending media file........" .$status."\n\n";

print_r($appendrequest);

file_put_contents( $nameoffile.".json", serialize($appendrequest), FILE_APPEND);

echo "Printing log of request ........" .$status."\n\n"; 


//Postfields for Finializing File to media after appending

$finalpostfields = array (
		'command' => 'FINALIZE',
		'media_id' => $media_id
			
		);

$finalresponse = $twitter->setPostfields($finalpostfields)
    ->buildOauth($url, $requestMethod)
    ->performRequest();
    
$status = $twitter->getHttpStatusCode();

$finalrequest = json_decode($finalresponse, true);

echo "Finalizing media file........" .$status."\n\n";

print_r($finalrequest);

file_put_contents( $nameoffile.".json", serialize($finalrequest), FILE_APPEND);

echo "Printing log of request ........" .$status."\n\n"; 

?>