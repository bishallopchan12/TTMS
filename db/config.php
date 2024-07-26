<?php
$servname = "localhost";
$username = "root";
$password = "bishal";
$db = "tms";



$conn = mysqli_connect($servname, $username, $password, $db);
if ($conn) {
    // echo "Connected";
} else {
    mysqli_connect_error();
}
?>