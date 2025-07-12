<?php
require 'configuration.php';

// Check if player ID is provided
if (isset($_GET['id'])) {
    $playerId = $_GET['id'];

    // Delete the player from the database
    $deleteQuery = "DELETE FROM players WHERE fide_id = $playerId";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        // Player deleted successfully
        header("Location: players.php");
        exit();
    } else {
        echo "Error deleting player: " . mysqli_error($conn);
    }
} else {
    echo "No player ID provided.";
}
?>