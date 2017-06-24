<?php
session_start();
$chkBoxArr = array(1,2,3);

 $data=array(
		'name' =>'cartname',
		'customerId' => 1,
		'proid'=>$chkBoxArr
);
$postfields = http_build_query($data);
$url = 'http://localhost/shoppingcart/Show_Cart.php';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
echo $response_json = curl_exec($ch);
curl_close($ch);
 $response=json_decode($response_json, true);


?>
