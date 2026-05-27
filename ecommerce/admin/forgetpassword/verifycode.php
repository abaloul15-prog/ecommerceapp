<?php

include __DIR__ . "/../../connect.php";


$email = filterRequest("email");
$insertedverifcode = filterRequest("verifycode");

$stmt = $con->prepare("SELECT * FROM `admin` WHERE `admin_email`= ? AND `admin_verifycode` = ?");
$stmt->execute(array($email , $insertedverifcode));

$count = $stmt->rowCount();

result($count);