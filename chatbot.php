<?php
session_start();
include('include/config.php');

header('Content-Type: application/json');

function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}

function getResponse($message, $dbh) {
    $message = strtolower(sanitizeInput($message));
    $response = "Hello! How can I assist you with your travel plans today? Ask about packages, destinations, offers, or your bookings!";

    // Package-related queries
    if (strpos($message, 'package') !== false || strpos($message, 'tour') !== false) {
        if (strpos($message, 'list') !== false || strpos($message, 'all') !== false) {
            $sql = "SELECT PackageName, PackagePrice, PackageLocation FROM tbltourpackages LIMIT 5";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            if ($results) {
                $response = "Here are some popular tour packages in Nepal:<br>";
                foreach ($results as $result) {
                    $response .= "- {$result['PackageName']} (Rs {$result['PackagePrice']}) - {$result['PackageLocation']}<br>";
                }
                $response .= "Want more details about any package? Just ask!";
            }
        } else {
            $packageName = trim(str_replace(['package', 'tour'], '', $message));
            $sql = "SELECT PackageName, PackagePrice, PackageDetails, PackageLocation FROM tbltourpackages WHERE LOWER(PackageName) LIKE :name LIMIT 1";
            $query = $dbh->prepare($sql);
            $query->execute([':name' => "%$packageName%"]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $response = "Here's the details for {$result['PackageName']}:<br>";
                $response .= "Price: Rs {$result['PackagePrice']}<br>";
                $response .= "Location: {$result['PackageLocation']}<br>";
                $response .= "Details: " . substr($result['PackageDetails'], 0, 150) . "...<br>";
                $response .= "Interested? Ask me how to book!";
            } else {
                $response = "I couldn’t find that package. Try 'Kathmandu Cultural Tour' or 'Pokhara Adventure Package'!";
            }
        }
    }
    // Offer-related queries
    elseif (strpos($message, 'offer') !== false || strpos($message, 'discount') !== false) {
        $sql = "SELECT OfferName, OfferPrice, PercentageOff, OfferLocation FROM packageoffer LIMIT 3";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($results) {
            $response = "Here are some current offers:<br>";
            foreach ($results as $result) {
                $response .= "- {$result['OfferName']} (Rs {$result['OfferPrice']}, {$result['PercentageOff']} off) - {$result['OfferLocation']}<br>";
            }
            $response .= "Let me know if you want to book one!";
        }
    }
    // Destination-related queries
    elseif (strpos($message, 'destination') !== false || strpos($message, 'place') !== false) {
        $sql = "SELECT DestinationName, DestinationDetails FROM tbldestination LIMIT 3";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($results) {
            $response = "Here are some top destinations in Nepal:<br>";
            foreach ($results as $result) {
                $response .= "- {$result['DestinationName']}: " . substr($result['DestinationDetails'], 0, 100) . "...<br>";
            }
            $response .= "Ask me for more details about any destination!";
        }
    }
    // Nearby attractions
    elseif (strpos($message, 'near me') !== false || strpos($message, 'nearby') !== false) {
        $sql = "SELECT PlaceName, Activities FROM near_me LIMIT 3";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($results) {
            $response = "Here are some nearby attractions in Nepal:<br>";
            foreach ($results as $result) {
                $response .= "- {$result['PlaceName']} (Activities: {$result['Activities']})<br>";
            }
        }
    }
    // Booking-related queries
    elseif (strpos($message, 'booking') !== false || strpos($message, 'book') !== false) {
        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
            $sql = "SELECT BookingId, PackageId, status FROM booking WHERE Email = :email ORDER BY BookingTime DESC LIMIT 1";
            $query = $dbh->prepare($sql);
            $query->execute([':email' => $email]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $status = $result['status'] == 1 ? 'Confirmed' : 'Pending';
                $response = "Your latest booking (ID: {$result['BookingId']}) for Package ID {$result['PackageId']} is {$status}. Need more help?";
            } else {
                $response = "You haven’t made any bookings yet. Want to explore some packages?";
            }
        } else {
            $response = "Please sign in to check your bookings. Want to see available packages instead?";
        }
    }

    return $response;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $message = $_POST['message'];
    $reply = getResponse($message, $dbh);
    echo json_encode(['response' => $reply]);
} else {
    echo json_encode(['response' => 'Invalid request. Please try again!']);
}
?>