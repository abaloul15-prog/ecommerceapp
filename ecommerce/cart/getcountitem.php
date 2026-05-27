<?php

include "../connect.php";

$usersid = filterRequest("usersid");
$itemsid = filterRequest("itemsid");


$stmt = $con->prepare("SELECT COUNT(cart.cart_id) AS countitems FROM `cart` WHERE cart.cart_usersid = ? AND cart.cart_itemsid = ? AND cart_order = 0");
$stmt->execute(array( $usersid , $itemsid));
$count = $stmt->rowCount();

$data = $stmt->fetchColumn();


if ($count > 0) {
    echo json_encode(array("status" => "success", "data" => $data));
    } else {
        echo json_encode(array("status" => "success", "data" => "0"));
} 