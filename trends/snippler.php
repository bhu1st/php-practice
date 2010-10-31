<?php

//simple procedure to find trends from large stream of text data
// check my snipplr - http://snipplr.com/view/40983/word-frequency-count/

$filename = "11.txt";

/* get content of $filename in $content */
$content = strtolower(file_get_contents($filename));

/* split $content into array of substrings of $content i.e wordwise */
$wordArray = preg_split('/[^a-z]/', $content, -1, PREG_SPLIT_NO_EMPTY);

/* "stop words", filter them */
$filteredArray = array_filter($wordArray, function($x){
       return 		!preg_match("/^(.|a|an|and|the|this|at|in|or|of|is|for|to)$/",$x);
     });
	 
/* get associative array of values from $filteredArray as keys and their frequency count as value */
$wordFrequencyArray = array_count_values($filteredArray);

/* Sort array from higher to lower, keeping keys */
arsort($wordFrequencyArray);

/* grab Top 10, huh sorted? */
$top10words = array_slice($wordFrequencyArray,0,10);

/* display them */
foreach ($top10words as $topWord => $frequency)
    echo "$topWord --  $frequency<br/>";

?>