<?php 

$notAuth = "";

include "connect.php";

// Test sending a notification
$title   = "Test Notification";
$message = "Hello! This is a test number 1 message to services";
$topic   = "services";     // make sure devices are subscribed to this topic
$pageid  = "";
$pagename = "";

// Call your function
$response = sendGCM($title, $message, $topic, $pageid, $pagename);


// Show the response
echo "<pre>";
print_r($response);
echo "</pre>";



?>