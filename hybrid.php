<?php
// Combine both recommendation lists (collaborative + content-based)
$final_recommendations = array_merge($collaborative_recommendations, $content_recommendations);

// Remove duplicates
$final_recommendations = array_unique($final_recommendations);

// Optional: You can give weights to the two recommendation methods
$collaborative_weight = 0.7;  // 70% importance to collaborative filtering
$content_weight = 0.3;        // 30% importance to content-based filtering

$package_scores = [];

// Step 1: Assign scores to collaborative recommendations
foreach ($collaborative_recommendations as $package_id) {
    if (!isset($package_scores[$package_id])) {
        $package_scores[$package_id] = 0;
    }
    $package_scores[$package_id] += $collaborative_weight;
}

// Step 2: Assign scores to content-based recommendations
foreach ($content_recommendations as $package_id) {
    if (!isset($package_scores[$package_id])) {
        $package_scores[$package_id] = 0;
    }
    $package_scores[$package_id] += $content_weight;
}

// Sort recommendations by score
arsort($package_scores);

// Step 3: Get the details of top recommended packages
$top_recommended_packages = array_keys($package_scores);
if (!empty($top_recommended_packages)) {
    $top_recommended_packages_str = implode(",", $top_recommended_packages);
    $query = "SELECT * FROM packages WHERE PackageId IN ($top_recommended_packages_str)";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Recommended Package: " . $row['PackageName'] . "<br>";
        echo "Location: " . $row['Location'] . "<br>";
        echo "Price: " . $row['Price'] . "<br>";
        echo "Rating: " . $row['Rating'] . "<br><br>";
    }
} else {
    echo "No recommendations available at this time.";
}
?>
