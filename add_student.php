<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}
include("db/connect.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if username exists
    $check = "SELECT * FROM students WHERE username='$username'";
    $result = $conn->query($check);

    if ($result->num_rows > 0) {
        $message = "❌ Username already exists!";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO students (name, username, password) VALUES ('$name', '$username', '$hashed')";
        if ($conn->query($sql)) {
            $message = "✅ Student added successfully!";
        } else {
            $message = "❌ Error: " . $conn->error;
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Student</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
  <h1>Add New Student</h1>
  <nav>
    <a href="view_feedback.php">Dashboard</a>
    <a href="create_admin.php">Add Admin</a>
    <a href="logout.php">Logout</a>
  </nav>
</header>

<main>
  <?php if($message != "") echo "<p style='text-align:center;'>$message</p>"; ?>

  <form action="" method="POST">
    <label for="name">Student Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Add Student</button>
  </form>
</main>

<footer>
  <p>&copy; 2025 Student Feedback System</p>
</footer>
</body>
</html>
