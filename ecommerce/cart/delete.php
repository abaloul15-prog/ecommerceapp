<?php

include "../connect.php";

// $usersid = filterRequest("usersid");
// $itemsid = filterRequest("itemsid");

// deleteData("cart", "cart_id = (SELECT cart_id FROM cart WHERE cart_usersid = $usersid AND cart_itemsid = $itemsid AND cart_order = 0 LIMIT 1)");


$usersid = filterRequest("usersid");
$itemsid = filterRequest("itemsid");

$stmt = $con->prepare("SELECT cart_id FROM cart WHERE cart_usersid = ? AND cart_itemsid = ? AND cart_order = 0 LIMIT 1");
$stmt->execute([$usersid, $itemsid]);
$cartId = $stmt->fetchColumn();

if ($cartId) {
    deleteData("cart", "cart_id = $cartId AND cart_order = 0");
} else {
    echo json_encode(array("status" => "failure", "message" => "No item found"));
}
