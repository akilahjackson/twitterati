<?php


$datafromfile = file_get_contents("uomaryland/First_Page.json",TRUE);
	
	$json = unserialize($datafromfile);
	
print_r($json);


?>