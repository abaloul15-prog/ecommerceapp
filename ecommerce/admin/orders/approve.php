<?php

include "../../connect.php";


$ordersid = filterRequest("ordersid");
$usersid = filterRequest("usersid");
$orderstype = filterRequest("orderstype");

if ($orderstype == "0") {
    $data = array(
    "orders_status" => 1
);
}

if ($orderstype == "1") {
    $data = array(
    "orders_status" => 3
);
}


updateData("orders", $data, "orders_id = $ordersid AND orders_status = 0") ;

// sendGCM("Success", "Your order has been successfuly approved", "users$usersid", "none", "refreshpendingorders");
insertNotification("Order status update", "Your order has been successfuly approved" , $usersid, "users$usersid", "none", "refreshpendingorders");

if ($orderstype == "0") {
 sendGCM("New delivery", "An order is now ready for delivery", "delivery", "none", "none");
}