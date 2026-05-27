<?php

include "../../connect.php";

$email = filterRequest("email");
$verifycode = rand(1000, 9999);

$data = array("delivery_verifycode" => $verifycode);

updateData("delivery", $data, "delivery_email = '$email'");

sendEmail($email, "Your confirmation code", "Verify code: $verifycode");