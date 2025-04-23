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
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: "Poppins", sans-serif;
                background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
                min-height: 100vh;
                padding: 60px 20px;
                position: relative;
                overflow-x: hidden;
            }

            body::before {
                content: "";
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: url("https://images.unsplash.com/photo-1507521628349-6e9b8a9a1a3b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80") no-repeat center center/cover;
                opacity: 0.15;
                z-index: -1;
                transform: translateY(0);
                transition: transform 0.1s ease;
            }

            /* Parallax effect on scroll */
            body.scrolled::before {
                transform: translateY(calc(var(--scroll) * -0.3px));
            }

            .container {
                max-width: 1000px;
                margin: 0 auto;
                padding: 40px;
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(12px);
                border-radius: 30px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
                position: relative;
                z-index: 1;
                transition: all 0.5s ease;
            }

            h1 {
                font-size: 3rem;
                font-weight: 800;
                background: linear-gradient(45deg, #ff6f61, #ffeb3b);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                text-align: center;
                margin-bottom: 2.5rem;
                text-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                position: relative;
                animation: gradientShift 5s infinite linear;
            }

            @keyframes gradientShift {
                0% {
                    background-position: 0% 50%;
                }
                100% {
                    background-position: 200% 50%;
                }
            }

            h3 {
                font-size: 2rem;
                font-weight: 600;
                color: #ff6f61;
                text-align: center;
                margin: 3rem 0 2rem;
                position: relative;
            }

            h3::after {
                content: "";
                display: block;
                width: 60px;
                height: 4px;
                background: linear-gradient(to right, #ff6f61, #ffeb3b);
                margin: 0.5rem auto;
                border-radius: 2px;
            }

            .package-details {
                margin: 2rem 0;
                padding: 2rem;
                background: linear-gradient(145deg, #f0f4f8, #e2e8f0);
                border-radius: 20px;
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
                position: relative;
                overflow: hidden;
            }

            .package-details::before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: radial-gradient(circle at 10% 20%, rgba(255, 235, 59, 0.2), transparent 50%);
                z-index: -1;
            }

            .image-container {
                position: relative;
                overflow: hidden;
                border-radius: 20px;
                margin-bottom: 2rem;
                perspective: 1000px;
            }

            .package-image {
                width: 100%;
                height: 350px;
                object-fit: cover;
                border-radius: 20px;
                transition: transform 0.6s ease;
                transform-style: preserve-3d;
            }

            .image-container:hover .package-image {
                transform: rotateY(10deg) scale(1.05);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            }

            .image-container::after {
                content: "";
                position: absolute;
                inset: 0;
                background: linear-gradient(to top, rgba(0, 0, 0, 0.6), transparent 60%);
                transition: opacity 0.3s ease;
            }

            .image-container:hover::after {
                opacity: 0.7;
            }

            .package-info {
                margin-bottom: 1.5rem;
                font-size: 1.15rem;
                color: #2d3748;
                line-height: 1.7;
                position: relative;
            }

            .package-info strong {
                color: #ff6f61;
                font-weight: 600;
            }

            .package-recommendation {
                margin: 1.5rem 0;
                padding: 2rem;
                background: linear-gradient(145deg, #e6fffa, #b5f5ec);
                border-radius: 20px;
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
                position: relative;
                transition: all 0.4s ease;
                transform: translateY(0);
            }

            .package-recommendation:hover {
                transform: translateY(-5px) rotateX(5deg);
                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            }

            .package-recommendation::before {
                content: "";
                position: absolute;
                top: -10px;
                left: 20px;
                width: 50px;
                height: 50px;
                background: url("https://img.icons8.com/ios-filled/50/ff6f61/sparkling.png") no-repeat center center/cover;
                opacity: 0.3;
            }

            .package-name {
                font-size: 1.75rem;
                font-weight: 600;
                color: #1a3c34;
                margin-bottom: 1.25rem;
                position: relative;
            }

            .package-name::after {
                content: "";
                display: block;
                width: 30px;
                height: 3px;
                background: #1a3c34;
                margin-top: 0.5rem;
                border-radius: 2px;
            }

            .similarity {
                color: #718096;
                font-size: 0.95rem;
                margin-top: 1rem;
                font-style: italic;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .similarity::before {
                content: "★";
                color: #ffeb3b;
                font-size: 1.2rem;
            }

            .error {
                color: #fff;
                font-weight: 600;
                text-align: center;
                padding: 1.5rem;
                background: linear-gradient(145deg, #f56565, #e53e3e);
                border-radius: 12px;
                margin: 2rem auto;
                max-width: 500px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                body {
                    padding: 30px 15px;
                }

                .container {
                    padding: 25px;
                }

                h1 {
                    font-size: 2.25rem;
                }

                h3 {
                    font-size: 1.75rem;
                }

                .package-image {
                    height: 250px;
                }

                .package-name {
                    font-size: 1.5rem;
                }

                .package-info {
                    font-size: 1rem;
                }
            }

            @media (max-width: 480px) {
                h1 {
                    font-size: 1.75rem;
                }

                h3 {
                    font-size: 1.5rem;
                }

                .package-image {
                    height: 200px;
                }

                .package-recommendation {
                    padding: 1.5rem;
                }
            }
        </style>
    </head>
    <body>';

    // Parallax scroll effect
    echo '<script>
        window.addEventListener("scroll", () => {
            const scroll = window.scrollY;
            document.body.style.setProperty("--scroll", scroll);
            document.body.classList.add("scrolled");
        });
    </script>';

    if ($selectedPackage) {
        echo "<div class='container'>";
        echo "<h1>{$selectedPackage['PackageName']}</h1>";

        // Display package image
        if (!empty($selectedPackage['PackageImage'])) {
            echo "<div class='image-container'>";
            echo "<img class='package-image' src='{$selectedPackage['PackageImage']}' alt='{$selectedPackage['PackageName']}'>";
            echo "</div>";
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
                echo "<div class='image-container'>";
                echo "<img class='package-image' src='{$package['PackageImage']}' alt='{$package['PackageName']}'>";
                echo "</div>";
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