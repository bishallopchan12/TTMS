
<?php
// Assuming $booked_packages contains the user's previous bookings

// Step 1: Get the package types the user has booked
$package_types = [];
if (!empty($booked_packages)) {
    $booked_packages_str = implode(",", $booked_packages);
    $query = "SELECT DISTINCT PackageType FROM packages WHERE PackageId IN ($booked_packages_str)";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $package_types[] = $row['PackageType'];  // Example: Adventure, Historical, etc.
    }

    // Step 2: Recommend packages of similar types that the user hasn't booked yet
    if (!empty($package_types)) {
        $package_types_str = "'" . implode("','", $package_types) . "'";
        $query = "SELECT PackageId FROM packages WHERE PackageType IN ($package_types_str) AND PackageId NOT IN ($booked_packages_str)";
        $result = mysqli_query($conn, $query);
        $content_recommendations = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $content_recommendations[] = $row['PackageId'];
        }
    }
}
?>
