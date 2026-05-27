<?php

include __DIR__ . "/../../connect.php";

$categoriesId = filterRequest("categoriesId");
$categoriesName = filterRequest("categoriesName");
$categoriesNameNl = filterRequest("categoriesNameNl");
$oldImageName = filterRequest("oldImageName");

$result = imageUpload("../../upload/categories","files");

if ($result=="empty") {
    $data = array(
         "categories_name" => $categoriesName ,
         "categories_name_nl" => $categoriesNameNl ,
);
} else {
    deleteFile("../../upload/categories", $oldImageName);
    $data = array(
         "categories_name" => $categoriesName ,
         "categories_name_nl" => $categoriesNameNl ,
         "categories_image" => $result
);
}



updateData("categories" , $data, "categories_id = $categoriesId");