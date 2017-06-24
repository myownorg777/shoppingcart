<?php
include_once 'includes/class.database.php';
include_once 'api/products.php';
include_once 'includes/config.php';
 

 $instance= database::connect($dbDetails);

$product = new Product($instance);

// add the product to the database

$name = $_POST['name'];
$description =$_POST['description'];
$price = $_POST['price'];
$discount = $_POST['discount'];
$catId = $_POST['category_id'];

//$stmt = $product->insertProduct($a);

$price = trim(preg_replace('/([^0-9])/i', '', $price ));
  	// Trim any leading zeros
$price = trim(preg_replace('/(^[0]+)/i', '', $price ));

$discount = trim(preg_replace('/([^0-9])/i', '', $discount ));


  // If the price is zero or blank there's nothing for us to do
  if ( ! is_numeric($price) OR $price == 0)
  {
  $data = array("result" => 0, "message" => "Invalid price");

   return FALSE;
  
  }else if ( ! is_numeric($discount ) )
  {
  $data = array("result" => 0, "message" => "Invalid discount");

   return FALSE;
  
  }else{

 $response = $product->insertProduct($name,$description,$price,$discount,$catId);
 }
?>
