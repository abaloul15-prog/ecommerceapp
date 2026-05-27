<?php

include "../connect.php";

$email = filterRequest("email");
$verifycode = rand(1000 , 9999);

$stmt = $con->prepare("SELECT * FROM `users` WHERE `users_email` = ?");
$stmt->execute(array($email));

$count = $stmt->rowCount();

result($count);

if($count > 0){
$data = array("users_verifycode" =>  $verifycode ) ;
updateData("users", $data , "users_email = '$email'" , false);

    sendEmail($email , "Your confirmation code" , "Verify code: $verifycode");
}