<?php

include __DIR__ . "/../../connect.php";

$itemsId = filterRequest("itemsId");
$itemsName = filterRequest("itemsName");
$itemsNameNl = filterRequest("itemsNameNl");
$itemsDescription = filterRequest("itemsDescription");
$itemsDescriptionNl = filterRequest("itemsDescriptionNl");
$itemsQtyCount = filterRequest("itemsQtyCount");
$itemsPrice = filterRequest("itemsPrice");
$itemsDiscount = filterRequest("itemsDiscount");
$itemsCategory = filterRequest("itemsCategory");
$oldImageName = filterRequest("oldImageName");
$itemsActive = filterRequest("itemsActive");


$result = imageUpload("../../upload/items","files");

if ($result == "empty" || $result == "fail" ) {
   $data = array(
         "items_name" => $itemsName ,
         "items_name_nl" => $itemsNameNl ,
         "items_description" => $itemsDescription ,
         "items_description_nl" => $itemsDescriptionNl ,
         "items_quantitycount" => $itemsQtyCount ,
         "items_price" =>  $itemsPrice ,
         "items_discount" =>  $itemsDiscount ,
         "items_category" =>  $itemsCategory ,
         "items_active" => $itemsActive ,

        
);
} else {
    deleteFile("../../upload/items", $oldImageName);
  $data = array(
         "items_name" => $itemsName ,
         "items_name_nl" => $itemsNameNl ,
         "items_description" => $itemsDescription ,
         "items_description_nl" => $itemsDescriptionNl ,
         "items_quantitycount" => $itemsQtyCount ,
         "items_price" =>  $itemsPrice ,
         "items_discount" =>  $itemsDiscount ,
         "items_category" =>  $itemsCategory ,
         "items_image" => $result,
         "items_active" => $itemsActive ,

        
);
}



updateData("items" , $data, "items_id = $itemsId");