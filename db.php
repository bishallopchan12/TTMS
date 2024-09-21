<?php
// main.php
include('include/config.php');
// Include the db.php file where the connection is made

// include 'db.php';
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

// Example query (assuming your connection is now stored in $conn)
$query = "SELECT user_id, tour_id, rating FROM user_ratings";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Process the results
$preferences = [];
while ($row = mysqli_fetch_assoc($result)) {
    $preferences[$row['user_id']][$row['tour_id']] = $row['rating'];
}

// Output or further processing...

?>