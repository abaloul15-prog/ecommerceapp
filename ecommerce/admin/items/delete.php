<?php

include "../../connect.php";

$itemsId = filterRequest("itemsId");
$imageName = filterRequest("imageName");

deleteFile("../../upload/items",$imageName);


deleteData("items", "items_id = $itemsId");