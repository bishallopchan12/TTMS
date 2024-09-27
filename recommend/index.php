<?php
session_start();
error_reporting(0);

// Assume you have your database connection and query for top viewed packages here
include('admin/includes/config.php');
$sql = "SELECT * FROM tbltourpackages ORDER BY views DESC LIMIT 3"; // Fetch top 3 viewed packages
$query = $dbh->prepare($sql);
$query->execute();
$topViewedPackages = $query->fetchAll(PDO::FETCH_OBJ);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website Title</title>
    <style>
        .must-visit-places {
            background-color: #f9f9f9; /* Light background color */
            padding: 40px 20px; /* Padding around the section */
            text-align: center; /* Center align the text */
        }

        .must-visit-places h3 {
            font-size: 2.5em; /* Larger font size for the title */
            color: #333; /* Dark color for the title */
            margin-bottom: 20px; /* Space below the title */
        }

        .places-container {
            display: flex; /* Use flexbox for a responsive layout */
            justify-content: center; /* Center align items */
            flex-wrap: wrap; /* Allow wrapping to next line */
        }

        .place-card {
            background: white; /* White background for cards */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            margin: 10px; /* Margin between cards */
            overflow: hidden; /* Prevent overflow of child elements */
            width: 300px; /* Fixed width for cards */
            transition: transform 0.3s; /* Animation on hover */
        }

        .place-card:hover {
            transform: scale(1.05); /* Slight zoom effect on hover */
        }

        .place-image {
            width: 100%; /* Full width image */
            height: 200px; /* Fixed height */
            object-fit: cover; /* Cover the image without distortion */
        }

        .place-info {
            padding: 20px; /* Padding inside the card */
        }

        .place-info h4 {
            font-size: 1.5em; /* Font size for package name */
            color: #2c3e50; /* Darker color for package name */
            margin-bottom: 10px; /* Space below package name */
        }

        .place-location {
            font-size: 1.2em; /* Font size for location */
            color: #7f8c8d; /* Grey color for location */
        }

        .place-views {
            font-size: 1em; /* Font size for views */
            color: #95a5a6; /* Lighter grey for views */
            margin: 10px 0; /* Space above and below */
        }

        .view-details-btn {
            display: inline-block; /* Inline block for the button */
            padding: 10px 20px; /* Padding for button */
            background-color: #3498db; /* Button background color */
            color: white; /* White text color */
            border-radius: 5px; /* Rounded corners for button */
            text-decoration: none; /* Remove underline */
            transition: background-color 0.3s; /* Animation for hover */
        }

        .view-details-btn:hover {
            background-color: #2980b9; /* Darker blue on hover */
        }
    </style>
</head>
<body>
    <div id="page" class="page">
        <!-- ***site header html start*** -->
        <?php include 'include/navbar.php'; ?>
        <!-- ***site header html end*** -->

        <main id="content" class="site-main">
            <section class="package-inner-page">
                <div class="inner-package-detail-wrap">
                    <div class="container">
                        <!-- Must Visit Places Section -->
                        <div class="must-visit-places">
                            <h3>Must Visit Places</h3>
                            <div class="places-container">
                                <?php if (!empty($topViewedPackages)) : ?>
                                    <?php foreach ($topViewedPackages as $package) : ?>
                                        <div class="place-card">
                                            <img src="admin/packageimages/<?php echo htmlentities($package->PackageImage); ?>" alt="<?php echo htmlentities($package->PackageName); ?>" class="place-image">
                                            <div class="place-info">
                                                <h4><?php echo htmlentities($package->PackageName); ?></h4>
                                                <p class="place-location"><?php echo htmlentities($package->PackageLocation); ?></p>
                                                <p class="place-views">Views: <?php echo htmlentities($package->views); ?></p>
                                                <a href="package-detail.php?pkgid=<?php echo htmlentities($package->PackageId); ?>" class="view-details-btn">View Details</a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <p>No packages found.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

      
    <!-- JavaScript -->
    <?php include 'include/javascript.php'; ?>
</body>
</html>
