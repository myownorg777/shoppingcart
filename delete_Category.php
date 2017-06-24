<?php
include_once 'includes/class.database.php';
include_once 'api/category.php';
include_once 'includes/config.php';


$instance= database::connect($dbDetails);

$category= new Category($instance);

$catid = $_POST['catid'];


$response = $category->deleteCategory($catid);
 
 print_r($response);
 
 
?>
