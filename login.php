<?php
session_start();
include("db/connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; // raw input, because we'll verify hash

    // Get admin record from database
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verify entered password against stored hash
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin'] = $username;
            header("Location: view_feedback.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "Invalid username!";
    }

    echo "
    <html>
    <head>
      <meta http-equiv='refresh' content='2;url=login.html'>
      <style>
        body { font-family: Arial; text-align: center; margin-top: 50px; }
        .msg { background-color: #ffe0e0; border: 1px solid #ff0000; display: inline-block; padding: 20px; border-radius: 10px; }
      </style>
    </head>
    <body>
      <div class='msg'>
        <h3>❌ $error</h3>
        <p>Redirecting back to login...</p>
      </div>
    </body>
    </html>";
}

$conn->close();
?>
