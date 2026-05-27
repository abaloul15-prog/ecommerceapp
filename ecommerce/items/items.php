<?php

include "../connect.php";

$categoryid = filterRequest('id');
$usersid = filterRequest('usersid');

// getAllData("itemsview", "categories_id = $categoryid");


$stmt = $con->prepare("SELECT items1view.*, 1 AS favorite, (items_price - (items_price * items_discount / 100)) AS priceafterdiscount FROM items1view
INNER JOIN favorite ON favorite.favorite_itemsid = items1view.items_id AND favorite.favorite_usersid = ?
WHERE categories_id = ?
UNION ALL
SELECT *, 0 AS favorite, (items_price - (items_price * items_discount / 100)) AS priceafterdiscount FROM items1view
WHERE categories_id = ? AND items_id NOT IN ( SELECT items1view.items_id FROM items1view
INNER JOIN favorite ON favorite.favorite_itemsid = items1view.items_id AND favorite.favorite_usersid = ?)");

$stmt->execute(array($usersid, $categoryid, $categoryid, $usersid));
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $count  = $stmt->rowCount();

    if ($count > 0) {
 echo json_encode(array("status" => "success", "data" => $data));
    } else {
 echo json_encode(array("status" => "failure"));    }
    