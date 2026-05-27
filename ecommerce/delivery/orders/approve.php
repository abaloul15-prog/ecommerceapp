<?php

include __DIR__ . "/../../connect.php";

$ordersid = filterRequest("ordersid");
$usersid = filterRequest("usersid");
$deliveryid = filterRequest("deliveryid");

$data = array(
    "orders_status" => 2,
    "orders_delivery" => $deliveryid
    
);


updateData("orders", $data, "orders_id = $ordersid AND orders_status = 1") ;

insertNotification("Order status update", "Your order is now Out for delivery" , $usersid, "users$usersid", "none", "none");

sendGCM("To delivery", "An orders has been approved by the delivery man $deliveryid and is now out for delivery", "delivery", "none", "none");

sendGCM("To services", "An orders has been approved by a delivery man and is now out for delivery", "services", "none", "none");
