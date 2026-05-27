<?php

include __DIR__ . "/../../connect.php";


$email = filterRequest("email");
$verifycode = rand(1000 , 9999);


$data = array("admin_verifycode" => $verifycode);


updateData("admin", $data , "admin_email = '$email'");

sendEmail($email , "Your confirmation code" , "Verify code: $verifycode");
