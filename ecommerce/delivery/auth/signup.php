<?php

include "../../connect.php";

$username = filterRequest("username");
$email = filterRequest("email");
$phone = filterRequest("phone");
$password = sha1($_POST['password']);
$verifycode = rand(1000, 9999);

$stmt = $con->prepare("SELECT * FROM `delivery` WHERE `delivery_email` = ? OR `delivery_phone` = ?");
$stmt->execute(array($email, $phone));

$count = $stmt->rowCount();

if ($count > 0) {
    printFailure("email or phone error");
} else {
    $data = array(
        "delivery_name" => $username,
        "delivery_email" => $email,
        "delivery_phone" => $phone,
        "delivery_password" => $password,
        "delivery_verifycode" => $verifycode,
    );

    sendEmail($email, "Your confirmation code", "Verify code: $verifycode");

    insertData("delivery", $data);
}