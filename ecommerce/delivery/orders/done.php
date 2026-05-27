<?php

include __DIR__ . "/../../connect.php";

$ordersid = filterRequest("ordersid");
$usersid = filterRequest("usersid");

$data = array(
    "orders_status" => 3
);


updateData("orders", $data, "orders_id = $ordersid AND orders_status = 2") ;

// sendGCM("Success", "Your order has been successfuly approved", "users$usersid", "none", "refreshpendingorders");
insertNotification("Order status", "Your order has been successfuly delivered" , $usersid, "users$usersid", "none", "none");

sendGCM("To services", "Order delivered to the customer", "services", "none", "none");
