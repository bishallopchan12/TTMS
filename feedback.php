<?php
// Show PHP errors (useful for debugging)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection settings
$host = "localhost"; // or 127.0.0.1
$user = "root";      // default user for XAMPP
$password = "";      // no password by default
$dbname = "tms"; // your database name

// Create a connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data and prevent SQL injection
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $feedbk = $conn->real_escape_string($_POST['feedbk']);

    // Insert form data into the database
    $sql = "INSERT INTO feedback (name, email, feedbk) VALUES ('$name', '$email', '$feedbk')";

    if ($conn->query($sql) === TRUE) {
        $successMessage = "Thank you for your feedback!";
    } else {
        $errorMessage = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <style>
        /* Base styling for the body */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
        }

        /* Heading styling */
        h2 {
            text-align: center;
            color: #333;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        /* Form container styling */
        form {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            transition: transform 0.3s ease;
        }

        form:hover {
            transform: scale(1.05);
        }

        /* Label styling */
        label {
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
            font-size: 14px;
            color: #555;
        }

        /* Input fields and textarea styling */
        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            color: #333;
            background-color: #f9f9f9;
            transition: border-color 0.3s ease;
        }

        /* Focus effects on input fields */
        input[type="text"]:focus, input[type="email"]:focus, textarea:focus {
            border-color: #007bff;
            outline: none;
            background-color: #fff;
        }

        /* Submit button styling */
        input[type="submit"] {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 12px 15px;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            transition: background-color 0.3s ease;
        }

        /* Hover effect for submit button */
        input[type="submit"]:hover {
            background-color: #218838;
        }

        /* Success message */
        .success {
            color: #28a745;
            margin-bottom: 15px;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
        }

        /* Error message */
        .error {
            color: #e74c3c;
            margin-bottom: 15px;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
        }

        /* Media query for responsiveness */
        @media (max-width: 480px) {
            form {
                padding: 20px;
            }

            h2 {
                font-size: 24px;
            }

            input[type="submit"] {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <h2>Submit Your Feedback</h2>
    <form action="feedback.php" method="POST">
        <?php if (!empty($successMessage)) : ?>
            <p class="success"><?php echo $successMessage; ?></p>
        <?php endif; ?>

        <?php if (!empty($errorMessage)) : ?>
            <p class="error"><?php echo $errorMessage; ?></p>
        <?php endif; ?>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="feedbk">Feedback:</label>
        <textarea id="feedbk" name="feedbk" rows="5" required></textarea>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
