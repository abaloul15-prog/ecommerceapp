<?php

include __DIR__ . "/../../connect.php";


$username = filterRequest("username");
$email = filterRequest("email");
$phone = filterRequest("phone");
$password = sha1($_POST['password']);
$verifycode = rand(1000 , 9999);


$stmt = $con->prepare("SELECT * FROM `admin` WHERE `admin_email` = ? OR `admin_phone` = ?");
$stmt->execute(array($email , $phone));

$count = $stmt->rowCount();

if ($count > 0) {
printFailure("email or phone error");
} else {
    $data= array(
        "admin_name" => $username,
        "admin_email" => $email,
        "admin_phone" => $phone,
        "admin_password" => $password,
        "admin_verifycode" => $verifycode,
    );

    sendEmail($email , "Your confirmation code" , "Verify code: $verifycode");

    insertData("admin" , $data);
}