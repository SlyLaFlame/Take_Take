<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fideId = $_POST['fide_id'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $clubId = $_POST['club'];

    processPlayerData($fideId, $firstName, $lastName, $clubId, $conn);
}

function processPlayerData($fideId, $firstName, $lastName, $clubId, $conn)
{
    // Check if the player already exists in the database
    $checkPlayerQuery = "SELECT * FROM players WHERE fide_id = '$fideId'";
    $result = mysqli_query($conn, $checkPlayerQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        // Update the existing player
        $updatePlayerQuery = "UPDATE players SET first_name = '$firstName', last_name = '$lastName', club_id = '$clubId', club = (SELECT club_name FROM clubs WHERE club_id = '$clubId') WHERE fide_id = '$fideId'";

        mysqli_query($conn, $updatePlayerQuery);
    } else {
        // Insert a new player
        $insertPlayerQuery = "INSERT INTO players (fide_id, first_name, last_name, club_id, club) VALUES ('$fideId', '$firstName', '$lastName', '$clubId', (SELECT club_name FROM clubs WHERE club_id = '$clubId'))";
        mysqli_query($conn, $insertPlayerQuery);
    }
}
header ('location: view.php');
?>