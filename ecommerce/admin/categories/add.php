<?php

include __DIR__ . "/../../connect.php";

$categoriesName = filterRequest("categoriesName");
$categoriesNameNl = filterRequest("categoriesNameNl");
$categoriesImage = imageUpload("../../upload/categories","files");

$data = array(
         "categories_name" => $categoriesName ,
         "categories_name_nl" => $categoriesNameNl ,
         "categories_image" => $categoriesImage
);

insertData("categories" , $data);