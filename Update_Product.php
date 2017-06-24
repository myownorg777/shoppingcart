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
 $response = $product->updateProduct($name,$description,$price,$discount,$catId);
 
?>
