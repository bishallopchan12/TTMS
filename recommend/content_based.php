<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Utility functions for text vectorization and cosine similarity calculation
function vectorizeText($text) {
    $words = preg_split('/\W+/', strtolower($text));
    $stopWords = ['and', 'the', 'is', 'in', 'of', 'to', 'a'];
    return array_diff($words, $stopWords); // Remove stop words
}

function cosineSimilarity($vec1, $vec2) {
    $intersect = array_intersect($vec1, $vec2);
    $union = array_unique(array_merge($vec1, $vec2));
    return count($intersect) / count($union);
}

// Database connection details
$host = "localhost";   // or "127.0.0.1"
$user = "root";        // default user for XAMPP/WAMP
$password = "";        // default password is usually empty
$dbname = "tms";       // replace with your actual database name

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Retrieve user input (latitude, longitude, and clicked place ID)
$lat = isset($_GET['lat']) ? floatval($_GET['lat']) : null;
$lng = isset($_GET['lng']) ? floatval($_GET['lng']) : null;
$clickedPlaceId = isset($_GET['place_id']) ? intval($_GET['place_id']) : null;

if (!$lat || !$lng || !$clickedPlaceId) {
    die(json_encode(['error' => 'Invalid input']));
}

try {
    // Fetch the clicked place details using placeid
    $stmt = $conn->prepare("SELECT * FROM near_me WHERE placeid = ?");
    $stmt->bind_param("i", $clickedPlaceId);
    $stmt->execute();
    $result = $stmt->get_result();
    $clickedPlace = $result->fetch_assoc();

    if (!$clickedPlace) {
        die(json_encode(['error' => 'Place not found']));
    }

    // Vectorize the clicked place's description and activities
    $clickedPlaceVector = array_merge(
        vectorizeText($clickedPlace['description']),
        vectorizeText($clickedPlace['activities'])
    );

    // Fetch all other places
    $stmt = $conn->query("SELECT * FROM near_me");
    $places = $stmt->fetch_all(MYSQLI_ASSOC);

    // Calculate similarity for each place
    $recommendedPlaces = [];
    foreach ($places as $place) {
        if ($place['placeid'] == $clickedPlace['placeid']) continue; // Skip the clicked place

        $placeVector = array_merge(
            vectorizeText($place['description']),
            vectorizeText($place['activities'])
        );

        $similarity = cosineSimilarity($clickedPlaceVector, $placeVector);
        $recommendedPlaces[] = [
            'placename' => $place['placename'],
            'description' => $place['description'],
            'activities' => $place['activities'],
            'imagesrc' => $place['imagesrc'],
            'placelatlong' => $place['placelatlong'],
            'similarity' => $similarity
        ];
    }

    // Sort by similarity (highest first)
    usort($recommendedPlaces, function ($a, $b) {
        return $b['similarity'] <=> $a['similarity'];
    });

    // Return top 5 most similar places
    echo json_encode(array_slice($recommendedPlaces, 0, 5));

} catch (Exception $e) {
    echo json_encode(['error' => 'Caught exception: ' . $e->getMessage()]);
}
