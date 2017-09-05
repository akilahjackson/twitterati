<?php


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


$jsonfile = file_get_contents("terps-results.json");

preg_match_all($pattern, $jsonfile, $matches);
print_r($matches[0]);

file_put_contents( "cleanterps-results.json", $matches[0]);


?>