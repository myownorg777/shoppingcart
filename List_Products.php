<?php
include_once 'includes/class.database.php';
include_once 'api/products.php';
include_once 'includes/config.php';
 

 $instance= database::connect($dbDetails);

$product = new Product($instance);

// List the product from the database

$productId = $_POST['product_id'];

 echo $response = $product->getProductById($productId);

?>
