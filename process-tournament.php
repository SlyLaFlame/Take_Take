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

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve the form data
  $tournamentName = $_POST["tournament_name"];
  $tournamentVenue = $_POST["tournament_venue"];
  $startDate = $_POST["start_date"];
  $endDate = $_POST["end_date"];
  $maxRound = $_POST["max_round"];

  //performm server side start-date validation
  $currentDate=date ('Y-m-d');//current date
  if ($startDate<$currentDate){
    echo "invalid start-date, please pick another date (from today onwards) to proceed with tournament creation";
    exit;
  }
  //perform serverside end date validation
  /* if ($endDate<$startDate) {
    echo "this end-date is not valid. Please check the start-date and enter a valid one";
    exit;
  } */

  // Create the SQL query
  $sql = "INSERT INTO tournament_details (tournament_name, tournament_venue, start_date, end_date, max_round) 
  VALUES ('$tournamentName', '$tournamentVenue', '$startDate', '$endDate','$maxRound')";

  // Execute the SQL query
  if (mysqli_query($conn, $sql)) {
    echo "Tournament information stored successfully";
  } else {
    echo "Error: " . mysqli_error($conn);
  }
}

// Close the database connection
//mysqli_close($conn);
?>