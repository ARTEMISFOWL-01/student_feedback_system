<?php
$servername = "localhost";
$username = "root";  // default for XAMPP
$password = "";      // default empty
$database = "feedback_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
