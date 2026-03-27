<?php
//configiration
$xml=simplexml_load_file("config.xml");

//get temblites name use the url (preview/?theme=dima)
$Item = (isset($_GET['theme']) ? $_GET['theme'] : null);

// if is not set first theme showing as default
if($Item == null){
	$Item= $xml->children()->getName();
}

//attractions temblites information 
$name= $xml->$Item->children()->name;  //temblites name
$label=$xml->$Item->children()->label; //temblites label or Category 
$color=$xml->$Item->children()->color; //temblites label or Category 
$closeUrl=$xml->$Item->children()->closeUrl; //close url 
$purchaseUrl=$xml->$Item->children()->purchaseUrl; //temblites prices  
$temblitesUrl=$xml->$Item->children()->temblitesUrl; //temblites   
$rating= $xml->$Item->children()->rating; //temblites rating  
$Price=$xml->$Item->children()->Price;


//RatingClass return css class depend on rating value
//out String ()
//in int Value
function RatingClass($RatingVal){
  $RatingClass;
  if ($RatingVal>=3 && $RatingVal <=3.5) {
    $RatingClass="good";
  }elseif ($RatingVal>3.6 && $RatingVal <=4.5) {
    $RatingClass="very-good";
  }elseif ($RatingVal>4.5) {
    $RatingClass="perfect";
  }
  return $RatingClass;
}
  
?>