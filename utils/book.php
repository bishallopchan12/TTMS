<?php
// Database connection parameters
$host = 'localhost'; // Change if your DB is hosted elsewhere
$user = 'root';
$pass = '';
$db = 'tms';

// Create a connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['message' => 'Database connection failed: ' . $conn->connect_error]));
}

// Get the JSON input from the request
$data = json_decode(file_get_contents('php://input'), true);

// Check if the required fields are set
if (isset($data['firstName']) && isset($data['placeName']) && isset($data['packageType'])) {
    $userName = $conn->real_escape_string($data['firstName']);
    $packageName = $conn->real_escape_string($data['packageType']);
    $userEmail = $conn->real_escape_string($data['email']); // Assuming email is sent

    // Insert booking into database
    $sql = "INSERT INTO recbook (user_name, user_email, package_name) VALUES ('$userName', '$userEmail', '$packageName')";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Booking successful!']);
    } else {
        echo json_encode(['message' => 'Error: ' . $conn->error]);
    }
} else {
    echo json_encode(['message' => 'Invalid input.']);
}

// Close the database connection
$conn->close();
?>
