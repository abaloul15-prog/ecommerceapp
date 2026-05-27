<?php

include "../connect.php";

$email = filterRequest("email");
$password = sha1($_POST['password']);


// $stmt = $con->prepare("SELECT * FROM `users` WHERE `users_email` = ? AND `users_password` = ? AND `users_approve` = ?");
// $stmt->execute(array($email , $password , "1"));

// $count = $stmt->rowCount();

// result($count);

getData("users" , "`users_email` = ? AND `users_password` = ?" , array($email , $password));