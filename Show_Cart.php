<?php
include_once 'includes/config.php';
include_once 'includes/class.database.php';
include_once 'api/cart.php';

 $instance= database::connect($dbDetails);
 
$cart = new Cart($instance);
$cartname =$_POST['name'];
  $response = $cart->showCart($cartname);
echo json_encode($response);
exit();

  
?>
