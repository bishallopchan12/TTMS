<?php
include('config.php');

function haversine($lat1, $lon1, $lat2, $lon2) {
    $earth_radius = 6371;
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    
    $a = sin($dLat / 2) * sin($dLat / 2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon / 2) * sin($dLon / 2);
         
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $earth_radius * $c;
}

$query = "SELECT * FROM locations";
$result = $conn->query($query);
$locations = [];
while($row = $result->fetch_assoc()) {
    $locations[] = $row;
}

foreach ($locations as $loc1) {
    foreach ($locations as $loc2) {
        if ($loc1['id'] != $loc2['id']) {
            $distance = haversine($loc1['latitude'], $loc1['longitude'], $loc2['latitude'], $loc2['longitude']);
            $stmt = $conn->prepare("INSERT INTO distances (from_location_id, to_location_id, distance) VALUES (?, ?, ?)");
            $stmt->bind_param("iid", $loc1['id'], $loc2['id'], $distance);
            $stmt->execute();
        }
    }
}

echo "Distances calculated and stored!";
?>
