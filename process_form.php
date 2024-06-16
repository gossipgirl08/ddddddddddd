<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP password is empty
$dbname = "process_form"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    if (isset($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        // Debug: Log the received data
        error_log("Received data: Name=$name, Email=$email, Subject=$subject, Message=$message");

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssss", $name, $email, $subject, $message);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Your message has been sent successfully!";
            } else {
                $_SESSION['message'] = "Error executing statement: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $_SESSION['message'] = "Error preparing statement: " . $conn->error;
        }
    } else {
        $_SESSION['message'] = "All fields are required.";
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