<?php
// Database connection code
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to get all locations
function getAllLocations($conn) {
    $sql = "SELECT * FROM locations";
    $result = $conn->query($sql);
    $locations = [];
    while ($row = $result->fetch_assoc()) {
        $locations[$row['id']] = $row['name'];
    }
    return $locations;
}

// Function to get all distances
function getAllDistances($conn) {
    $sql = "SELECT * FROM distances";
    $result = $conn->query($sql);
    $distances = [];
    while ($row = $result->fetch_assoc()) {
        $distances[$row['source_id']][$row['destination_id']] = [
            'distance' => $row['distance'],
            'time' => $row['travel_time'],
            'cost' => $row['travel_cost']
        ];
    }
    return $distances;
}
?>
