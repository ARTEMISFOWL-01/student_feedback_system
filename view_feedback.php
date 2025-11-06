<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}
include("db/connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Feedback</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
  <h1>Admin Dashboard</h1>
  <nav>
  <a href="view_feedback.php">View Feedback Form</a>
  <a href="create_admin.php">Create Admin<a>
  <a href="logout.php">Logout</a>
</nav>

</header>

<main>
  <h2>Submitted Feedbacks</h2>

  <table border="1" cellspacing="0" cellpadding="10" style="margin:auto; border-collapse:collapse;">
    <tr style="background-color:#004080; color:white;">
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Subject</th>
      <th>Message</th>
      <th>Date</th>
    </tr>

    <?php
    $sql = "SELECT * FROM feedback ORDER BY date DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['subject']}</td>
                    <td>{$row['message']}</td>
                    <td>{$row['date']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6' style='text-align:center;'>No feedback available</td></tr>";
    }

    $conn->close();
    ?>
  </table>
</main>

<footer>
  <p>&copy; 2025 Student Feedback System</p>
</footer>

</body>
</html>
