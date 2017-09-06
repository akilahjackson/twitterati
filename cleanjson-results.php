<?php

/// Step 1 - reformat Twitter Search Results into something close to json
$pattern = '
/
\{              # { character
    (?:         # non-capturing group
        [^{}]   # anything that is not a { or }
        |       # OR
        (?R)    # recurses the entire pattern
    )*          # previous group zero or more times
\}              # } character
/x
';

$jsonfile = file_get_contents("all-maryland.json");

preg_match_all($pattern, $jsonfile, $matches);


print_r($matches[0]);

file_put_contents( "naked-md.json", $matches[0]);

/// Step 2 - replace the }{ with },{

$pattern2 = '/\} \{/';
$replacement = '/\},\{/';

$jsonfile2 = file_get_contents("naked-md.json");

$results = preg_replace($pattern2, $replacement, $jsonfile2);

file_put_contents("md-json-results.json", $results[0]);

?>