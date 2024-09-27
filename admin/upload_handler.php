<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "tms"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $placename = $conn->real_escape_string($_POST['placename']);
    $activities = $conn->real_escape_string($_POST['activities']);
    $description = $conn->real_escape_string($_POST['description']);
    $placelatlong = $conn->real_escape_string($_POST['placelatlong']);
    
    // Handle file upload for image
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["imagesrc"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is a valid image type
    $check = getimagesize($_FILES["imagesrc"]["tmp_name"]);
    if ($check !== false) {
        if (move_uploaded_file($_FILES["imagesrc"]["tmp_name"], $target_file)) {
            $imagesrc = $target_file;

            // Insert data into the table
            $sql = "INSERT INTO near_me (placename, activities, description, placelatlong, imagesrc)
                    VALUES ('$placename', '$activities', '$description', '$placelatlong', '$imagesrc')";

            if ($conn->query($sql) === TRUE) {
                echo "New place data uploaded successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your image.";
        }
    } else {
        echo "File is not an image.";
    }
}

$conn->close();
?>
