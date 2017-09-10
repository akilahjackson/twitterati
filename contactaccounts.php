<?php
	
	$datafromfile = file_get_contents('umuc/First_Page.json');
	
	$json = unserialize($datafromfile);
	
//	print_r($json);
	
	
	$keystoarray = array_keys($json);
	
	for($i = 0; $i < count($json); $i++) {
		
		echo $keystoarray[$i] . "\n\n";
		
		foreach($json[$keystoarray[$i]] as $key => $value) {
			
			print_r($json["users"][$key]["screen_name"]);
			echo "\n\n";
			
		}
	}
		


?>