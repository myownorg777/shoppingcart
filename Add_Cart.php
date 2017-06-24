<?php
include_once 'includes/config.php';
include_once 'includes/class.database.php';
include_once 'api/cart.php';
include_once 'api/products.php';
include_once 'api/category.php';

 $instance= database::connect($dbDetails);
 
$cart = new Cart($instance);
$product = new Product($instance);
$category = new category($instance);
// add item into cart 
$cartname =$_POST['name'];
$customerId =$_POST['customerId'];
$product_idarr = $_POST['proid'];
$total_price = 0;
$total_discount = 0;
$total_tax = 0;
//print_r($product_idarr);exit();
if(count($product_idarr)==0){
	$data = array("result" => 0, "message" => "Add Items");
}else
{
foreach($product_idarr as $product_id){
 
$cart->addItem($product_id,1);
$total_price = $total_price+ $product->getPrice($product_id);
$total_discount = $total_discount+ (float)$product->getDiscount($product_id);
$total_tax = $total_tax+ (float)$category->getTax($product->getCategory($product_id));
$_SESSION['items']=$product_id;

}

$products= $cart->serializeCart();

$discount_total =  $cart->getTotalDiscountPrice();
$tax_total=$cart->getTotalTaxPrice();

$total_discount = number_format((($total_price -$discount_total )/$total_price)*100,2);
$total_tax = number_format((($tax_total / $total_price )*100),2);


$grand_total= $cart->getTotal();  
  
  echo $response = $cart->insertCart($cartname,$products,$total_price, $total_discount,$discount_total,$total_tax,$tax_total,$grand_total);
} 
exit();

  
?>
