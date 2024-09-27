<?php
// Database connection (replace with your connection details)
$conn = mysqli_connect("localhost", "root", "", "tms");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch top 3 packages sorted by views in descending order
$packagesQuery = "SELECT * FROM tbltourpackages ORDER BY views DESC LIMIT 3"; // Fetch top 3 packages
$packagesResult = mysqli_query($conn, $packagesQuery);

if (!$packagesResult) {
    echo "Error fetching packages: " . mysqli_error($conn);
} else {
    // Check if any packages were found
    if (mysqli_num_rows($packagesResult) > 0) {
        echo "<h1>Top 3 Packages by Views</h1>";
        echo "<div class='package-grid'>";
        
        while ($package = mysqli_fetch_assoc($packagesResult)) {
            // Display each package's details in a card format
            echo "<div class='package-card'>";

            // Construct the image URL
            $imageUrl = 'uploads/' . $package['PackageImage']; // Adjust this path if necessary
            
            // Debugging output to show constructed image path
            echo "<!-- Image Path: {$imageUrl} -->"; 
            
            // Check if the file exists before displaying it
            if (file_exists($imageUrl)) {
                echo "<img src='{$imageUrl}' alt='{$package['PackageName']}' class='package-image'>";
            } else {
                // If the file does not exist, show a placeholder image
                echo "<img src='uploads/default.jpg' alt='Default Image' class='package-image'>";
                echo "<p class='error-message'>Image not found: {$imageUrl}</p>"; // Output the missing image path
            }

            echo "<h2>{$package['PackageName']}</h2>";
            echo "<p><strong>Location:</strong> {$package['PackageLocation']}</p>";
            echo "<p>{$package['PackageDetails']}</p>";
            echo "<p><strong>Views:</strong> {$package['views']}</p>";
            echo "<a class='view-button' href='package.php?PackageId={$package['PackageId']}'>View Details</a>";
            echo "</div>"; // End of package-card
        }
        
        echo "</div>"; // End of package-grid
    } else {
        echo "<p>No packages found.</p>";
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!-- Add some CSS for styling -->
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
    }

    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 30px;
        font-size: 2.5em;
        animation: fadeIn 1s ease-in-out;
    }

    .package-grid {
        display: flex;
        justify-content: center;
        gap: 30px;
    }

    .package-card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 20px;
        width: 300px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        overflow: hidden;
        text-align: center;
        position: relative;
        animation: fadeInUp 0.5s ease forwards;
    }

    .package-image {
        width: 100%;
        height: 200px;
        border-radius: 12px 12px 0 0;
        object-fit: cover;
        transition: transform 0.3s;
    }

    .package-card:hover .package-image {
        transform: scale(1.05); /* Scale image on hover */
    }

    .package-card h2 {
        font-size: 1.5em;
        color: #007bff;
        margin-top: 15px;
    }

    .package-card p {
        color: #555;
        line-height: 1.5;
        margin-top: 10px;
    }

    .view-button {
        display: inline-block;
        margin-top: 15px;
        padding: 12px 20px;
        background-color: #28a745;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .view-button:hover {
        background-color: #218838;
    }

    .error-message {
        color: red;
        font-size: 0.9em;
        margin-top: 5px;
    }

    /* Keyframes for fadeInUp animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
