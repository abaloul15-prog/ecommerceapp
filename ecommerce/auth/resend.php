<?php

include "../connect.php";

$email = filterRequest("email");
$verifycode = rand(1000 , 9999);


$data = array("users_verifycode" => $verifycode);


updateData("users", $data , "users_email = '$email'");

sendEmail($email , "Your confirmation code" , "Verify code: $verifycode");
