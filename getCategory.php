<?php

// define available categories in Amazon

$ret = array(
	array("name"=>"All","value"=>"All"),
	array("name"=>"Apparel","value"=>"Apparel"),
	array("name"=>"Appliances","value"=>"Appliances"),
	array("name"=>"Arts and Crafts","value"=>"ArtsAndCrafts"),
	array("name"=>"Baby","value"=>"Baby"),
	array("name"=>"Beauty","value"=>"Beauty"),
	array("name"=>"Books","value"=>"Books"),
	array("name"=>"eBooks","value"=>"eBooks"),
	array("name"=>"Electronics","value"=>"Electronics"),
	array("name"=>"DVD","value"=>"DVD"),
	array("name"=>"Digital Music Album","value"=>"DigitalMusicAlbum"),
	array("name"=>"Grocery","value"=>"Grocery"),
	array("name"=>"Home Garden","value"=>"HomeGarden"),
	array("name"=>"Health Personal Care","value"=>"HealthPersonalCare"),
	array("name"=>"Kitchen","value"=>"Kitchen"),
	array("name"=>"Movie","value"=>"Movie"),
	array("name"=>"Music","value"=>"Music"),
	array("name"=>"Outdoor Living","value"=>"OutdoorLiving"),
	array("name"=>"Pet Supplies","value"=>"PetSupplies"),
	array("name"=>"Software","value"=>"Software"),
	array("name"=>"Sporting Goods","value"=>"SportingGoods"),
	array("name"=>"Toys","value"=>"Toys"),
	array("name"=>"Video Games","value"=>"VideoGames"),
	array("name"=>"Watches","value"=>"Watches")
);			    

echo json_encode($ret);


?>