<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}
include("db/connect.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = mysqli_real_escape_string($conn, $_POST['username']);
    $new_password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if username already exists
    $check = "SELECT * FROM users WHERE username='$new_username'";
    $result = $conn->query($check);

    if ($result->num_rows > 0) {
        $message = "❌ Username already exists!";
    } else {
        // Hash the password securely
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $insert = "INSERT INTO users (username, password) VALUES ('$new_username', '$hashed_password')";
        if ($conn->query($insert) === TRUE) {
            $message = "✅ New admin created successfully!";
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create New Admin</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
  <h1>Create New Admin</h1>
  <nav>
    <a href="view_feedback.php">Dashboard</a>
    <a href="logout.php">Logout</a>
  </nav>
</header>

<main>
  <?php if($message != "") echo "<p style='text-align:center;'>$message</p>"; ?>

  <form action="" method="POST">
    <label for="username">New Admin Username:</label>
    <input type="text" id="username" name="username" required>

    <label for="password">New Admin Password:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Create Admin</button>
  </form>
</main>

<footer>
  <p>&copy; 2025 Student Feedback System</p>
</footer>

</body>
</html>
