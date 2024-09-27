<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "tms");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if a package ID is passed via POST
if (isset($_POST['id'])) {  // Use $_POST to capture the 'id' sent via POST
    $packageId = intval($_POST['id']);
    
    // Increment the views for the package
    $updateViewsQuery = "UPDATE tbltourpackages SET views = views + 1 WHERE PackageId = $packageId";
    if (!mysqli_query($conn, $updateViewsQuery)) {
        echo "Error updating views: " . mysqli_error($conn);
    }

    // Fetch the package details
    $packageQuery = "SELECT * FROM tbltourpackages WHERE PackageId = $packageId";
    $packageResult = mysqli_query($conn, $packageQuery);
    
    if (!$packageResult) {
        echo "Error fetching package: " . mysqli_error($conn);
    } else {
        if (mysqli_num_rows($packageResult) > 0) {
            $package = mysqli_fetch_assoc($packageResult);
            // Display the package details
            echo "<h1>{$package['PackageName']}</h1>";
            echo "<p>Location: {$package['PackageLocation']}</p>";
            echo "<p>Details: {$package['PackageDetails']}</p>";
            echo "<p>Views: {$package['views']}</p>"; // Display the updated views
        } else {
            echo "No package found for the provided ID.";
        }
    }
} else {
    echo "Package ID not provided.";
}

mysqli_close($conn);
?>
