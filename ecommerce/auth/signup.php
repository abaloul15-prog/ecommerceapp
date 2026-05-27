<?php

include "../connect.php";

$username = filterRequest("username");
$email = filterRequest("email");
$phone = filterRequest("phone");
$password = sha1($_POST['password']);
$verifycode = rand(1000 , 9999);


$stmt = $con->prepare("SELECT * FROM `users` WHERE `users_email` = ? OR `users_phone` = ?");
$stmt->execute(array($email , $phone));

$count = $stmt->rowCount();

if ($count > 0) {
printFailure("email or phone error");
} else {
    $data= array(
        "users_name" => $username,
        "users_email" => $email,
        "users_phone" => $phone,
        "users_password" => $password,
        "users_verifycode" => $verifycode,
    );

    sendEmail($email , "Your confirmation code" , "Verify code: $verifycode");

    insertData("users" , $data);
}