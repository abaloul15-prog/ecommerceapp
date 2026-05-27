<?php

include __DIR__ . "/../../connect.php";

$itemsName = filterRequest("itemsName");
$itemsNameNl = filterRequest("itemsNameNl");
$itemsDescription = filterRequest("itemsDescription");
$itemsDescriptionNl = filterRequest("itemsDescriptionNl");
$itemsQtyCount = filterRequest("itemsQtyCount");
// $itemsActive = filterRequest("itemsActive");
$itemsPrice = filterRequest("itemsPrice");
$itemsDiscount = filterRequest("itemsDiscount");
$itemsDateTimeNow = filterRequest("itemsDateTimeNow");
$itemsCategory = filterRequest("itemsCategory");
$itemsImage = imageUpload("../../upload/items","files");


$data = array(
         "items_name" => $itemsName ,
         "items_name_nl" => $itemsNameNl ,
         "items_description" => $itemsDescription ,
         "items_description_nl" => $itemsDescriptionNl ,
         "items_quantitycount" => $itemsQtyCount ,
        //  "items_active" => "1" ,
         "items_price" =>  $itemsPrice ,
         "items_discount" =>  $itemsDiscount ,
         "items_date" => $itemsDateTimeNow ,
         "items_category" =>  $itemsCategory ,
         "items_image" => $itemsImage
        
);

insertData("items" , $data);