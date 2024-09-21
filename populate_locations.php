<?php
include('config.php');

$locations = [
    ['city_name' => 'CityA', 'latitude' => 40.712776, 'longitude' => -74.005974],
    ['city_name' => 'CityB', 'latitude' => 34.052235, 'longitude' => -118.243683],
    // Add more cities as needed
];

foreach ($locations as $location) {
    $stmt = $conn->prepare("INSERT INTO locations (city_name, latitude, longitude) VALUES (?, ?, ?)");
    $stmt->bind_param("sdd", $location['city_name'], $location['latitude'], $location['longitude']);
    $stmt->execute();
}

echo "Locations populated successfully!";
?>
