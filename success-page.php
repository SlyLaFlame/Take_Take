<?php
session_start(); // Start the PHP session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
  // If the user is not logged in, redirect to the login page
  header('Location: login.php');
  exit;
}

// Get the username from the session
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome, <?php echo $username; ?></title>
</head>

<body>
    <h1>Welcome, <?php echo $username; ?></h1>
    <p>You have successfully logged in!</p>
    <a href="logout.php">Logout</a>
</body>

</html>