<?php
include_once 'includes/class.database.php';
include_once 'api/products.php';
include_once 'includes/config.php';


$instance= database::connect($dbDetails);

$Product= new Product($instance);

$product_id = $_POST['product_id'];


$response = $Product->deleteProduct($product_id);
 
 print_r($response);
 
 
?>
