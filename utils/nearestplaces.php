<?php
header('Content-Type: application/json');

// Database connection
$host = 'localhost';
$db = 'tms';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get user coordinates from URL parameters
    $lat = isset($_GET['lat']) ? floatval($_GET['lat']) : null;
    $lng = isset($_GET['lng']) ? floatval($_GET['lng']) : null;

    $stmt = $pdo->prepare("SELECT placename, activities, description, placelatlong, imagesrc FROM near_me");
    $stmt->execute();

    $places = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($places as &$place) {
        $place['imagesrc'] = 'http://localhost/B-B-Travel-and-Tours-Bishal/admin/' . $place['imagesrc']; // Adjust if necessary
    }

    echo json_encode($places);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
