<?php

include "../connect.php";


$ordersid = filterRequest("ordersid");
$rating = filterRequest("rating");
$noterating = filterRequest("noterating");


 $data= array(
        "orders_rating" => $rating,
        "orders_noterating" => $noterating,
    );


   updateData("orders" , $data , "orders_id = '$ordersid'");
