<?php

include "connect.php";

$alldata = array();
$alldata['status'] = "success";
//categories
$categories = getAllData("categories", null, null, false);
$alldata['categories'] = $categories;

//items
$items = getAllData("itemsbestselling", "1=1 ORDER BY countitemsbestselling DESC", null, false);
$alldata['items'] = $items;

//foruitems
$foruitems = getAllData("foruitemsview", "items_discount != 0", null, false);
$alldata['foruitems'] = $foruitems;

//settings
$settings = getAllData("settings", "1=1", null, false);
$alldata['settings'] = $settings;


echo json_encode($alldata);

?>
