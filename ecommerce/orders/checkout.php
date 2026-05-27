<?php

include "../connect.php";


$usersid = filterRequest("usersid");
$addressid = filterRequest("addressid");
$orderstype = filterRequest("orderstype");
$pricedelivery = filterRequest("pricedelivery");
$ordersprice = filterRequest("ordersprice");
$couponid = filterRequest("couponid");
$paymentmethod = filterRequest("paymentmethod");
$coupondiscount = filterRequest("coupondiscount");

if($orderstype == 1){
  $pricedelivery = 0; 
}

$totalprice = $ordersprice + $pricedelivery;

//Check coupon
$now = date("Y-m-d H:i:s");

$checkCoupon = getData("coupon" , "`coupon_id` = ? AND `coupon_expiredate` > ? AND `coupon_count` > ?",array($couponid, $now, 0), false );

if ($checkCoupon > 0) {
$totalprice = $totalprice - ( $ordersprice * $coupondiscount / 100 ) ; 

$stmt = $con->prepare("UPDATE `coupon` SET `coupon_count`= `coupon_count` - 1 WHERE coupon_id = $couponid");
$stmt->execute();  
}


$data = array(
 "orders_usersid" => $usersid, 
 "orders_address" => $addressid, 
 "orders_type" => $orderstype, 
 "orders_pricedelivery" => $pricedelivery, 
 "orders_price" => $ordersprice, 
 "orders_coupon" => $couponid, 
 "orders_totalprice" => $totalprice,
 "orders_paymentmethod" => $paymentmethod,  
);


$count  = insertData("orders" , $data , false);


if ($count > 0) {
    $stmt = $con->prepare("SELECT MAX(orders_id) FROM orders");
    $stmt->execute();
    $maxId = $stmt->fetchColumn();

    $dataUpdateOrder = array(
 "cart_order" => $maxId, );

    updateData("cart", $dataUpdateOrder , "cart_usersid = $usersid AND cart_order = 0");
}