<?php
$servname = "localhost";
$username = "root";
$password = "";
$db = "tms";

// Create connection
$conn = mysqli_connect($servname, $username, $password, $db);

// Check connection
if (!$conn) {
    // If connection fails, output the error and stop the script
    die("Connection failed: " . mysqli_connect_error());
} else {
    // Uncomment the next line to confirm connection (for debugging purposes)
    // echo "Connected successfully";
}
?>
