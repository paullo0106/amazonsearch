<?php

// define available locations in Amazon
// Possible Country-Codes: de, com, co.uk, ca, fr, co.jp, it, cn, es

$ret = array(
	array("name"=>"US","value"=>"com"),
	array("name"=>"Canada","value"=>"ca"),
	array("name"=>"Japan","value"=>"co.jp"),
	array("name"=>"UK","value"=>"co.uk"),
	array("name"=>"China","value"=>"cn"),
	array("name"=>"French","value"=>"fr")
);			    

echo json_encode($ret);


?>