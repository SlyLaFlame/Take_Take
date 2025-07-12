<?php

include 'process-players.php';


if (isset($_GET['id'])) {
    $playerId = $_GET['id'];

    
    $query = "SELECT * FROM players WHERE fide_id = $playerId";
    $result = mysqli_query($conn, $query);

    
    if ($result && mysqli_num_rows($result) > 0) {
        $player = mysqli_fetch_assoc($result);

        
        $tournamentQuery = "SELECT tournament_id FROM tournament_details ORDER BY tournament_id DESC LIMIT 1";
        $tournamentResult = mysqli_query($conn, $tournamentQuery);
        $row = mysqli_fetch_assoc($tournamentResult);
        $tournamentId = $row['tournament_id'];

        
        if ($tournamentId) {
            // Check if the tournament_id exists in the tournament_details table
            $tournamentExistsQuery = "SELECT tournament_id FROM tournament_details WHERE tournament_id = $tournamentId";
            $tournamentExistsResult = mysqli_query($conn, $tournamentExistsQuery);
            $tournamentExists = mysqli_num_rows($tournamentExistsResult) > 0;

            if ($tournamentExists) {
                // Update the player's tournament_id
                $updateQuery = "UPDATE players SET tournament_id = $tournamentId, approved = 1 WHERE fide_id = $playerId";
                $updateResult = mysqli_query($conn, $updateQuery);

                if ($updateResult) {
                    // Player approved successfully
                    echo "Player approved for the tournament.";
                    header("location:details.php");
                } else {
                    // Failed to update player's tournament_id
                    echo "Failed to update the player's tournament ID.";
                }
            } else {
                // Actual tournament ID does not exist
                echo "The actual tournament ID does not exist.";
            }
        } else {
            // No tournament_id found
            echo "No tournament ID found.";
        }
    } else {
        echo "Player not found.";
    }
} else {
    echo "No player ID provided.";
}
