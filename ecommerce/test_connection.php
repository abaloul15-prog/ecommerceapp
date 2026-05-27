<?php
include 'connect.php';

// Test if connection works
if ($con) {
    echo "Database connection successful!";
    
    // Optional: Test a simple query
    try {
        $stmt = $con->query("SELECT 1");
        echo "<br>Database query test: SUCCESS";
    } catch (PDOException $e) {
        echo "<br>Query test failed: " . $e->getMessage();
    }
} else {
    echo "Connection failed!";
}
?>




<!-- 
include "connect.php";


sendEmail("jewlentina23@gmail.com" , "Hi" , "I am Mouad, this was from sendEmail function!") ;
 -->
