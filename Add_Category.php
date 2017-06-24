<?php
include_once 'includes/config.php';
include_once 'includes/class.database.php';
include_once 'api/category.php';



$instance= database::connect($dbDetails);

$category= new Category($instance);

$name = $_POST['name'];
$description =$_POST['description'];
$Tax = $_POST['tax'];


$response = $category->insertCategory($name,$description,$Tax);
 
 print_r($response);
 
 
?>
