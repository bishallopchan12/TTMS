<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = mysqli_connect("localhost", "root", "", "tms");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to tokenize and normalize text
function tokenize($text) {
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9\s]/', '', $text);
    return explode(" ", $text);
}

// Function to create a term frequency vector from a text
function createVector($tokens) {
    $vector = [];
    foreach ($tokens as $token) {
        if (isset($vector[$token])) {
            $vector[$token]++;
        } else {
            $vector[$token] = 1;
        }
    }
    return $vector;
}

// Function to compute cosine similarity between two vectors
function cosineSimilarity($vecA, $vecB) {
    $dotProduct = 0;
    $magnitudeA = 0;
    $magnitudeB = 0;

    $allTerms = array_unique(array_merge(array_keys($vecA), array_keys($vecB)));

    foreach ($allTerms as $term) {
        $a = isset($vecA[$term]) ? $vecA[$term] : 0;
        $b = isset($vecB[$term]) ? $vecB[$term] : 0;

        $dotProduct += $a * $b;
        $magnitudeA += pow($a, 2);
        $magnitudeB += pow($b, 2);
    }

    $magnitudeA = sqrt($magnitudeA);
    $magnitudeB = sqrt($magnitudeB);

    return ($magnitudeA * $magnitudeB == 0) ? 0 : $dotProduct / ($magnitudeA * $magnitudeB);
}

// Check if the package type is provided
if (isset($_POST['type'])) {
    $packageType = mysqli_real_escape_string($conn, $_POST['type']);

    // Fetch the selected package by type
    $query = "SELECT * FROM tbltourpackages WHERE PackageType = '$packageType'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error fetching selected package: " . mysqli_error($conn));
    }

    $selectedPackage = mysqli_fetch_assoc($result);

    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tour Package Recommendation</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMw45jC+5yMQUrP0vYB5PUF4eE5PL1e5Qa9h2" crossorigin="anonymous">
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 20px;
                background: #f8f9fa;
            }
            .container {
                max-width: 800px;
                margin: auto;
                padding: 20px;
                background: white;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }
            h1 {
                color: #343a40;
                text-align: center;
            }
            h3 {
                color: #007bff;
                margin-top: 20px;
            }
            .package-details {
                margin: 20px 0;
                padding: 20px;
                border: 1px solid #dee2e6;
                border-radius: 5px;
                background: #e9ecef;
            }
            .package-image {
                max-width: 100%;
                height: auto;
                border-radius: 5px;
                margin-bottom: 20px;
            }
            .package-info {
                margin-bottom: 20px;
            }
            .package-recommendation {
                margin: 10px 0;
                padding: 10px;
                border-radius: 5px;
                background: #e2f0d9;
                border: 1px solid #c3e6cb;
            }
            .package-name {
                font-size: 18px;
                font-weight: bold;
                color: #155724;
            }
            .similarity {
                color: #6c757d;
                font-size: 14px;
            }
            .error {
                color: red;
                font-weight: bold;
            }
        </style>
    </head>
    <body>';

    if ($selectedPackage) {
        echo "<div class='container'>";
        echo "<h1>{$selectedPackage['PackageName']}</h1>";

        // Display package image
        if (!empty($selectedPackage['PackageImage'])) {
            echo "<img class='package-image' src='{$selectedPackage['PackageImage']}' alt='{$selectedPackage['PackageName']}'>";
        }

        echo "<div class='package-details'>";
        echo "<div class='package-info'><strong>Location:</strong> {$selectedPackage['PackageLocation']}</div>";
        echo "<div class='package-info'><strong>Details:</strong> {$selectedPackage['PackageDetails']}</div>";
        echo "</div>";

        $selectedTokens = tokenize($selectedPackage['PackageDetails']);
        $selectedVector = createVector($selectedTokens);

        // Fetch all packages of the same type
        $query = "SELECT * FROM tbltourpackages WHERE PackageType = '$packageType' AND PackageId != {$selectedPackage['PackageId']}";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("Error fetching other packages: " . mysqli_error($conn));
        }

        $recommendations = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $tokens = tokenize($row['PackageDetails']);
            $vector = createVector($tokens);

            $similarity = cosineSimilarity($selectedVector, $vector);

            $recommendations[] = [
                'package' => $row,
                'similarity' => $similarity
            ];
        }

        usort($recommendations, function($a, $b) {
            return $b['similarity'] <=> $a['similarity'];
        });

        echo "<h3>Recommended Packages</h3>";
        foreach (array_slice($recommendations, 0, 3) as $recommendation) {
            $package = $recommendation['package'];
            echo "<div class='package-recommendation'>";
            echo "<p class='package-name'>{$package['PackageName']}</p>";

            // Display recommended package image
            if (!empty($package['PackageImage'])) {
                echo "<img class='package-image' src='{$package['PackageImage']}' alt='{$package['PackageName']}'>";
            }

            echo "<div class='package-info'><strong>Location:</strong> {$package['PackageLocation']}</div>";
            echo "<div class='package-info'><strong>Details:</strong> {$package['PackageDetails']}</div>";
            echo "<p class='similarity'>Similarity: " . round($recommendation['similarity'], 2) . "</p>";
            echo "</div>";
        }
        echo "</div>"; // Closing container
    } else {
        echo "<div class='error'>No package found for the given type.</div>";
    }
} else {
    echo "<div class='error'>Package type not provided.</div>";
}

mysqli_close($conn);

echo '</body>
</html>';
?>
