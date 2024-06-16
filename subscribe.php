<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP password is empty
$dbname = "your_database_name"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        // Debug: Log the received data
        error_log("Received data: Email=$email");

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO newsletters (email) VALUES (?)");
        if ($stmt) {
            $stmt->bind_param("s", $email);

            if ($stmt->execute()) {
                $_SESSION['message'] = "You have successfully signed up for the newsletter!";
            } else {
                $_SESSION['message'] = "Error executing statement: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $_SESSION['message'] = "Error preparing statement: " . $conn->error;
        }
    } else {
        $_SESSION['message'] = "Email field is required.";
    }
} else {
    $_SESSION['message'] = "Invalid request method.";
}

$conn->close();

// Debug: Log the redirection
error_log("Redirecting to index.html");

// Redirect back to the original page
header("Location: index.html");
exit();
?>