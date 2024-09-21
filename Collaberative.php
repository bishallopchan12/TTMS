<?php
// Database connection
include('include/config.php'); // Load the database connection details from config.php

// Current user email (this would usually be the logged-in user)
$user_email = 'sambadorje2024@gmail.com';

// Step 1: Get the current user's travel history (Package IDs they've booked)
$query = "SELECT PackageId FROM booking WHERE Email = '$user_email'";
$result = mysqli_query($conn, $query);
$booked_packages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $booked_packages[] = $row['PackageId'];
}

// Step 2: Find other users who booked the same packages
if (!empty($booked_packages)) {
    $booked_packages_str = implode(",", $booked_packages);
    $query = "SELECT DISTINCT Email FROM booking WHERE PackageId IN ($booked_packages_str) AND Email != '$user_email'";
    $result = mysqli_query($conn, $query);
    $similar_users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $similar_users[] = $row['Email'];
    }

    // Step 3: Recommend packages that similar users booked, but the current user hasn't
    if (!empty($similar_users)) {
        $similar_users_str = "'" . implode("','", $similar_users) . "'";
        $query = "
            $query = "
    SELECT PackageId, COUNT(*) as booking_count 
    FROM booking 
    WHERE Email IN ($similar_users_str) 
    AND PackageId NOT IN ($booked_packages_str)
    GROUP BY PackageId 
    ORDER BY booking_count DESC";

        $result = mysqli_query($conn, $query);
        $collaborative_recommendations = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $collaborative_recommendations[] = $row['PackageId'];
        }
    }
}
?>
