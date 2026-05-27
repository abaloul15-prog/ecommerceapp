<?php

include "../connect.php";

$email = filterRequest("email");
$insertedverifcode = filterRequest("verifycode");

$stmt = $con->prepare("SELECT * FROM `users` WHERE `users_email`= ? AND `users_verifycode` = ?");
$stmt->execute(array($email , $insertedverifcode));

$count = $stmt->rowCount();

result($count);