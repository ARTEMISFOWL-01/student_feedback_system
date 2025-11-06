<?php
session_start();
if (!isset($_SESSION['student'])) {
    header("Location: student_login.html");
    exit();
}

include("db/connect.php");

// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $student_username = $_SESSION['student'];
    $student_name = $_SESSION['student_name'];

    // Insert feedback with student reference
    $sql = "INSERT INTO feedback (student_username, name, subject, message)
            VALUES ('$student_username', '$student_name', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "
        <html>
        <head>
          <meta http-equiv='refresh' content='3;url=submit_feedback.php'>
          <style>
            body {
              font-family: Arial, sans-serif;
              text-align: center;
              margin-top: 50px;
            }
            .msg {
              background-color: #e0ffe0;
              border: 1px solid #00cc00;
              display: inline-block;
              padding: 20px;
              border-radius: 10px;
            }
          </style>
        </head>
        <body>
          <div class='msg'>
            <h2>✅ Thank you, $student_name!</h2>
            <p>Your feedback has been submitted successfully.</p>
            <p>Redirecting back to the form...</p>
          </div>
        </body>
        </html>";
    } else {
        echo "❌ Error: " . $conn->error;
    }

    $conn->close();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Submit Feedback</title>
  <link rel="stylesheet" href="css/style.css">
  <script>
    // Simple JS validation
    function validateFeedback() {
      const subject = document.getElementById("subject").value.trim();
      const message = document.getElementById("message").value.trim();
      if (subject === "" || message === "") {
        alert("Please fill in all fields before submitting!");
        return false;
      }
      return true;
    }
  </script>
</head>
<body>

<header>
  <h1>Welcome, <?php echo htmlspecialchars($_SESSION['student_name']); ?>!</h1>
  <nav>
    <a href="logout.php">Logout</a>
  </nav>
</header>

<main>
  <form action="" method="POST" onsubmit="return validateFeedback()">
    <label for="subject">Subject:</label>
    <input type="text" id="subject" name="subject" required>

    <label for="message">Message:</label>
    <textarea id="message" name="message" rows="4" required></textarea>

    <button type="submit">Submit Feedback</button>
  </form>
</main>

<footer>
  <p>&copy; 2025 Student Feedback System</p>
</footer>

</body>
</html>
