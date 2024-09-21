<?php
require 'db_connect.php';  // Includes the database connection and functions

$locations = getAllLocations($conn);
$distances = getAllDistances($conn);

// You can now use $locations and $distances in your logic, such as for the A* algorithm.
?>
