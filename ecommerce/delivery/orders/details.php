<?php

include __DIR__ . "/../../connect.php";

$ordersid = filterRequest("ordersid");

getAllData("ordersdetailsview" , "cart_order = $ordersid");