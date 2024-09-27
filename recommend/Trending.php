<?php
// Database connection (replace with your connection details)
$conn = mysqli_connect("localhost", "root", "", "tms");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch top 5 trending packages based on views
$trendingByViewsQuery = "
    SELECT PackageId, PackageName, PackageLocation, views
    FROM tbltourpackages
    ORDER BY views DESC
    LIMIT 5";  // You can adjust the limit to show more or fewer packages

$trendingByViewsResult = mysqli_query($conn, $trendingByViewsQuery);
?>

<!-- Frontend: Display Trending Places -->
<div class="container">
    <h2>Trending Packages (By Views)</h2>
    <?php
    if (mysqli_num_rows($trendingByViewsResult) > 0) {
        while ($row = mysqli_fetch_assoc($trendingByViewsResult)) {
            echo "<div class='trending-package'>";
            echo "<h3>{$row['PackageName']} - Views: {$row['views']}</h3>";
            echo "<p>Location: {$row['PackageLocation']}</p>";
            echo "<a href='package.php?PackageId={$row['PackageId']}'>View Package</a>";
            echo "</div>";
        }
    } else {
        echo "<p>No trending packages found.</p>";
    }
    ?>
</div>

<?php include "frontend/includes/footer.php"; ?>
