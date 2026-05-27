<?php

include __DIR__ . "/../../connect.php";

$categoriesId = filterRequest("categoriesId");
$imageName = filterRequest("imageName");

deleteFile("../../upload/categories",$imageName);

deleteData("categories", "categories_id = $categoriesId");