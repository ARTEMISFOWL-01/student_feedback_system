<?php
session_start();
include("db/connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM students WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $student = $result->fetch_assoc();

        // ⚡ Fix: set both username and name in session
        $_SESSION['student'] = $student['username'];
        $_SESSION['student_name'] = $student['name'];

        header("Location: submit_feedback.php");
        exit();
    } else {
        echo "
        <html><head>
          <meta http-equiv='refresh' content='2;url=student_login.html'>
          <style>
            body { font-family: Arial; text-align: center; margin-top: 50px; }
            .msg { background-color: #ffe0e0; border: 1px solid #ff0000; display: inline-block; padding: 20px; border-radius: 10px; }
          </style>
        </head>
        <body>
          <div class='msg'>
            <h3>❌ Invalid username or password!</h3>
            <p>Redirecting back to login...</p>
          </div>
        </body>
        </html>";
    }
}
?>
