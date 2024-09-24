<?php
// Start session
session_start();

// Initialize trips array from session
$trips = isset($_SESSION['trips']) ? $_SESSION['trips'] : [];

// Sample recommended places with coordinates
$recommendedPlaces = [
    ["name" => "Boudhanath Stupa", "lat" => 27.7212, "lon" => 85.3600],
    ["name" => "Pashupatinath Temple", "lat" => 27.7149, "lon" => 85.3475],
    ["name" => "Bhaktapur Durbar Square", "lat" => 27.6716, "lon" => 85.4267],
    ["name" => "Nagarkot", "lat" => 27.6978, "lon" => 85.4289],
    ["name" => "Changu Narayan", "lat" => 27.7045, "lon" => 85.5301]
];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $tripName = $_POST['name'];
    $tripLat = $_POST['lat'];
    $tripLon = $_POST['lon'];

    // Calculate distance from the selected location to each recommended place
    $nearestPlaces = [];
    foreach ($recommendedPlaces as $place) {
        $distance = getDistance($tripLat, $tripLon, $place['lat'], $place['lon']);
        $nearestPlaces[] = array_merge($place, ['distance' => $distance]);
    }

    // Sort recommended places by distance (nearest first)
    usort($nearestPlaces, function($a, $b) {
        return $a['distance'] <=> $b['distance'];
    });

    // Add new trip to the trips array
    $trips[] = [
        'id' => count($trips) + 1,
        'name' => $tripName,
        'coordinates' => [
            'lat' => (float)$tripLat,
            'lon' => (float)$tripLon
        ]
    ];

    // Save trips array to session
    $_SESSION['trips'] = $trips;
}

// Function to get the distance between two locations (in kilometers)
function getDistance($lat1, $lon1, $lat2, $lon2) {
    $earthRadius = 6371; // Radius of the Earth in kilometers

    // Convert latitude and longitude from degrees to radians
    $lat1 = deg2rad($lat1);
    $lon1 = deg2rad($lon1);
    $lat2 = deg2rad($lat2);
    $lon2 = deg2rad($lon2);

    // Calculate the difference in coordinates
    $dlat = $lat2 - $lat1;
    $dlon = $lon2 - $lon1;

    // Apply Haversine formula to calculate the distance
    $a = sin($dlat / 2) * sin($dlat / 2) +
         cos($lat1) * cos($lat2) *
         sin($dlon / 2) * sin($dlon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    // Distance in kilometers
    return $earthRadius * $c;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip Input</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <style>
        #map { height: 300px; }
    </style>
</head>
<body>
    <h1>Add a New Trip</h1>
    <form method="POST" action="">
        <label for="name">Trip Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        
        <label for="lat">Latitude:</label>
        <input type="text" id="lat" name="lat" required readonly><br><br>
        
        <label for="lon">Longitude:</label>
        <input type="text" id="lon" name="lon" required readonly><br><br>
        
        <input type="submit" value="Add Trip">
    </form>

    <div id="map"></div>

    <script>
        // Initialize the map
        var map = L.map('map').setView([27.7172, 85.324], 10); // Centered on Kathmandu

        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Add a marker on map click
        var marker;

        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lon = e.latlng.lng;

            // If there's an existing marker, remove it
            if (marker) {
                map.removeLayer(marker);
            }

            // Add a new marker for the selected trip
            marker = L.marker([lat, lon]).addTo(map);
            
            // Update the latitude and longitude input fields
            document.getElementById('lat').value = lat;
            document.getElementById('lon').value = lon;
        });

        // Add recommended places as markers on the map
        var recommendedPlaces = <?php echo json_encode($recommendedPlaces); ?>;
        
        recommendedPlaces.forEach(function(place) {
            L.marker([place.lat, place.lon]).addTo(map)
              .bindPopup(place.name);
        });
    </script>

    <h2>Nearest Recommended Places:</h2>
    <?php
    if (!empty($nearestPlaces)) {
        echo "<ul>";
        foreach (array_slice($nearestPlaces, 0, 3) as $place) { // Show top 3 nearest places
            echo "<li>{$place['name']} - Distance: {$place['distance']} km</li>";
        }
        echo "</ul>";
    }
    ?>

    <h2>Current Trips:</h2>
    <?php
    if (!empty($trips)) {
        echo "<ul>";
        foreach ($trips as $trip) {
            echo "<li>{$trip['name']} - Lat: {$trip['coordinates']['lat']}, Lon: {$trip['coordinates']['lon']}</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No trips added yet.</p>";
    }
    ?>
</body>
</html>
