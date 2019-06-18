<?php

require_once 'includes/AmazonECS.class.php';

// personal API key
define("API_KEY", "......");  // replace with correct API Key
define("SECRET_KEY", "......");  // replace with correct secret key
define("ASSOCIATE_TAG", "techblog0d3-20");

/*
 * Get top sellers, this can be invoked when users first enter our page and haven't started to search anything
 */
function getTopProduct(){
   $nodeId = '1000'; //ex: 1000:books, '2619525011': home beauty, default as book
   $client = new AmazonECS(API_KEY, SECRET_KEY, 'com',ASSOCIATE_TAG); // default as U.S.
   $response = $client->responseGroup('TopSellers')->browseNodeLookup($nodeId);//

   $topSeller = $response['BrowseNodes']['BrowseNode']['TopSellers']['TopSeller'];
   foreach($topSeller as $key => $value){
		$asinArray .= $value['ASIN'];
		if($key != 9) $asinArray .= ",";
    }
   $response = $client->responseGroup('Images,ItemAttributes,OfferSummary')->lookup($asinArray);
   
   return $response;
}

function searchProduct($category, $keyword, $location){
	// examples:
	//$response  = $client->category('DVD')->search('Dance'); 
    //$response  = $client->category('Software')->search('Adobe'); 
   	//$response = $client->category($category )->search($keyword); 
   	// category : All/Books/Software/DVD/Digital Music Album/Music
   
   	$client = new AmazonECS(API_KEY, SECRET_KEY, 'com',ASSOCIATE_TAG);
   	$response = $client->country($location)->category($category)->responseGroup('Images,ItemAttributes,OfferSummary')->search($keyword);
   	//$response = $client->category($category)->responseGroup('Images,ItemAttributes,OfferSummary')->search($keyword); // search without contry code
   	return $response;
}

/* 
 * Format product info to proper key-value pair for client-side to display later
 */
function formatProductInfo($products){

	foreach($products['Items']['Item'] as $value){
			
		$author = $value['ItemAttributes']['Author'];
	  	if(is_array($author)){ // Display only first author 
	      $author = $value['ItemAttributes']['Author'][0];
	   	}		
				
		$title = $value['ItemAttributes']['Title'];
		$title_length = strlen($value['ItemAttributes']['Title']);
				
		if($title_length>40){ // truncate the title when too long
				$title = substr($title,0,40)."......";    
		}
				
		$outputArr[] =  array("url"=>$value['DetailPageURL'], 
						      "title"=>$title, 
						      "group"=>$value['ItemAttributes']['ProductGroup'], 
						      "author"=>$author, 
						      "imageUrl"=>$value['MediumImage']['URL'],
						       "currency"=>$value['OfferSummary']['LowestNewPrice']['CurrencyCode'],
						       "price"=>$value['OfferSummary']['LowestNewPrice']['FormattedPrice'], 
						       "asin"=>$value['ASIN']
						);
						//other available options
						//$value['ItemAttributes']['ListPrice']['CurrencyCode'], //ListPrice: original price
						//$value['ItemAttributes']['ListPrice']['FormattedPrice'],

				   
	}
	return $outputArr;
}


$errors     = array();  // array to hold validation errors
$data 		= array(); 	// array to pass back data

// validate the variables ======================================================
if (empty($_POST['keyword'])){
	$errors['keyword'] = 'Keyword is required.';
	$products = getTopProduct(); // by default search topsellers for user
	//$ret = getTopProduct();
	$ret = formatProductInfo($products);
	$data['result'] = $ret;

}

$keyword = $_POST['keyword'];
$category = $_POST['category'];
$location = $_POST['location'];

// return a response ===========================================================

// response if there are errors
if ( ! empty($errors)) {
	// if there are items in our errors array, return those errors
	$data['success'] = false;
	$data['errors']  = $errors;
} else {
	$products = searchProduct($category,$keyword,$location);
	$ret = formatProductInfo($products);
	if (count($ret)==0){
		$errors['msg']='Found no result';
		$data['success'] = false;
		$data['errors']  = $errors;
	}
	else{
		//$data['errors'] = null; // clean previous result
		$data['success'] = true;
		$data['result'] = $ret;
	}
}


echo json_encode($data);

?>
