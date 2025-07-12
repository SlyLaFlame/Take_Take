<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "chess_players_db";
$port ="3307";

// Create a database connection
$conn = mysqli_connect($servername, $username, $password, $database,$port);

// Check if the connection was successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}