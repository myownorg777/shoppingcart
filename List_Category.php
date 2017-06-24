<?php
include_once 'includes/class.database.php';
include_once 'api/category.php';
include_once 'includes/config.php';
 

 $instance= database::connect($dbDetails);

$category = new Category($instance);

// List the category from the database

$categoryId = $_POST['category_id'];

 echo $response = $category->getCategoryById($categoryId);

?>
