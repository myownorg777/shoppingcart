<?php
include_once 'includes/class.database.php';
include_once 'api/category.php';
include_once 'includes/config.php';


$instance= database::connect($dbDetails);

$category= new Category($instance);

$name = $_POST['name'];
$description =$_POST['description'];
$Tax = $_POST['tax'];
$catid = $_POST['category_id'];

$response = $category->updateCategory($name,$description,$Tax,$catid);

 
 print_r($response);
 
 
?>
