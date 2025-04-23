<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "tms"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    $error_message = "Database connection failed: " . htmlspecialchars($conn->connect_error);
    render_response_page(false, $error_message);
    exit;
}

// Ensure Uploads directory exists
$target_dir = "Uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
}

// Handle form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize error array
    $errors = [];

    // Sanitize and validate inputs
    $placename = trim($_POST['placename'] ?? '');
    $activities = trim($_POST['activities'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $placelatlong = trim($_POST['placelatlong'] ?? '');

    if (empty($placename)) {
        $errors[] = "Place name is required.";
    }
    if (empty($placelatlong)) {
        $errors[] = "Location coordinates are required.";
    } elseif (!preg_match('/^-?\d+\.\d+,-?\d+\.\d+$/', $placelatlong)) {
        $errors[] = "Invalid coordinates format. Expected: latitude,longitude (e.g., 27.7172,85.3240).";
    }

    // Handle file upload
    $imagesrc = null;
    if (isset($_FILES['imagesrc']) && $_FILES['imagesrc']['error'] !== UPLOAD_ERR_NO_FILE) {
        $file = $_FILES['imagesrc'];
        $max_file_size = 5 * 1024 * 1024; // 5MB
        $allowed_types = ['image/jpeg', 'image/png'];
        $allowed_extensions = ['jpg', 'jpeg', 'png'];

        // Validate file
        $check = getimagesize($file['tmp_name']);
        if ($check === false) {
            $errors[] = "File is not a valid image.";
        } elseif ($file['size'] > $max_file_size) {
            $errors[] = "Image file is too large. Maximum size is 5MB.";
        } elseif (!in_array($file['type'], $allowed_types)) {
            $errors[] = "Only JPG and PNG images are allowed.";
        } else {
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($extension, $allowed_extensions)) {
                $errors[] = "Invalid file extension. Only .jpg, .jpeg, and .png are allowed.";
            } else {
                // Generate unique filename to prevent overwrites
                $filename = uniqid('place_') . '.' . $extension;
                $target_file = $target_dir . $filename;

                if (!move_uploaded_file($file['tmp_name'], $target_file)) {
                    $errors[] = "Failed to upload image.";
                } else {
                    $imagesrc = $target_file;
                }
            }
        }
    } else {
        $errors[] = "Image upload is required.";
    }

    // If no errors, insert into database
    if (empty($errors)) {
        // Sanitize inputs for SQL
        $placename = $conn->real_escape_string($placename);
        $activities = $conn->real_escape_string($activities);
        $description = $conn->real_escape_string($description);
        $placelatlong = $conn->real_escape_string($placelatlong);
        $imagesrc = $conn->real_escape_string($imagesrc);

        // Insert data with CreationDate
        $sql = "INSERT INTO near_me (placename, activities, description, placelatlong, imagesrc, CreationDate)
                VALUES ('$placename', '$activities', '$description', '$placelatlong', '$imagesrc', NOW())";

        if ($conn->query($sql) === TRUE) {
            render_response_page(true, "New place '$placename' uploaded successfully!");
        } else {
            $error_message = "Database error: " . htmlspecialchars($conn->error);
            render_response_page(false, $error_message);
        }
    } else {
        $error_message = implode("<br>", array_map('htmlspecialchars', $errors));
        render_response_page(false, $error_message);
    }
} else {
    render_response_page(false, "Invalid request method. Please use the upload form.");
}

$conn->close();

// Function to render styled response page
function render_response_page($success, $message) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $success ? 'Success' : 'Error'; ?> - Place Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Inter', sans-serif;
            color: #e2e8f0;
        }
        .response-container {
            background: rgba(30, 41, 59, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 100%;
            padding: 2.5rem;
            text-align: center;
            animation: fadeIn 0.6s ease-out;
        }
        .icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .success .icon {
            color: #34d399;
        }
        .error .icon {
            color: #f87171;
        }
        h2 {
            font-size: 1.875rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }
        p {
            font-size: 1rem;
            color: #94a3b8;
            margin-bottom: 2rem;
        }
        .back-button {
            display: inline-block;
            background: linear-gradient(to right, #3b82f6, #60a5fa);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.3s ease, background 0.3s ease;
        }
        .back-button:hover {
            transform: translateY(-2px);
            background: linear-gradient(to right, #2563eb, #3b82f6);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (max-width: 640px) {
            .response-container {
                padding: 1.5rem;
                margin: 1rem;
            }
            h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="response-container <?php echo $success ? 'success' : 'error'; ?>">
        <div class="icon"><?php echo $success ? '✅' : '❌'; ?></div>
        <h2><?php echo $success ? 'Success!' : 'Error'; ?></h2>
        <p><?php echo $message; ?></p>
        <a href="newadmin.php" class="back-button">Back to Upload</a>
    </div>
</body>
</html>
<?php
}
?>