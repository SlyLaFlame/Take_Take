<?php 
/* include 'navbar.php'; */
include 'connection.php';

// Retrieve the list of tournaments from the database
$tournamentsQuery = "SELECT * FROM tournament_details";
$tournamentsResult = mysqli_query($conn, $tournamentsQuery);

?>