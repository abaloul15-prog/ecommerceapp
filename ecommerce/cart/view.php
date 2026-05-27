<?php

include "../connect.php";


$usersid = filterRequest("usersid");

$datacart = getAllData("cartview" , "cart_usersid = ?" , array($usersid) , false);


$stmt = $con->prepare("SELECT SUM(cartview.itemsprice) AS totalprice , SUM(cartview.itemscount) AS totalcount FROM `cartview` WHERE cartview.cart_usersid = ? GROUP BY cartview.cart_usersid");

$stmt->execute(array($usersid));


$datacountandprice = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode(array(
 "status" => "success",
 "datacart" => $datacart,
 "datacount&price" => $datacountandprice,
));