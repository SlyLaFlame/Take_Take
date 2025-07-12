<?php
include 'connection.php';
include 'process-players.php';
include 'navbar.php';

// Function to get player's full name by FIDE ID
function getPlayerFullName($fideId, $conn)
{
    $selectPlayerQuery = "SELECT first_name, last_name FROM players WHERE fide_id = '$fideId'";
    $result = mysqli_query($conn, $selectPlayerQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $firstName = $row['first_name'];
        $lastName = $row['last_name'];
        return $firstName . " " . $lastName;
    }

    return "";
}

// Check if the "Clear Pairings" button is clicked
if (isset($_POST['clear_pairings'])) {
    // Clear the pairings by deleting the rows from the pairings table
    $clearPairingsQuery = "DELETE FROM pairings";
    mysqli_query($conn, $clearPairingsQuery);
}

// Check if the "Generate Pairings" button is clicked
if (isset($_POST['generate_pairings'])) {
    // Clear existing pairings
    $clearPairingsQuery = "DELETE FROM pairings";
    mysqli_query($conn, $clearPairingsQuery);

    // Fetch the latest tournament ID from the tournament_details table
    $selectTournamentQuery = "SELECT tournament_id FROM tournament_details ORDER BY tournament_id DESC LIMIT 1";
    $result = mysqli_query($conn, $selectTournamentQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $tournamentId = $row['tournament_id'];

        // Fetch all players from the database
        $selectPlayersQuery = "SELECT fide_id FROM players";
        $result = mysqli_query($conn, $selectPlayersQuery);

        // Create an array to store the players
        $players = array();

        // Check if there are players in the database
        if ($result && mysqli_num_rows($result) > 0) {
            // Store the players in the array
            while ($row = mysqli_fetch_assoc($result)) {
                $players[] = $row['fide_id'];
            }

            // Randomize the order of players
            shuffle($players);

            // Generate pairings
            $numPlayers = count($players);
            $roundNumber = 1;

            for ($i = 0; $i < $numPlayers - 1; $i += 2) {
                $player1 = $players[$i];
                $player2 = $players[$i + 1];

                // Get the full names of players
                $player1Name = getPlayerFullName($player1, $conn);
                $player2Name = getPlayerFullName($player2, $conn);

                // Insert the pairings into the pairings table
                $insertPairingsQuery = "INSERT INTO pairings (tournament_id, player1_fide_id, player1_name, player2_fide_id, player2_name, round_number) 
                VALUES ('$tournamentId', '$player1', '$player1Name', '$player2', '$player2Name', $roundNumber)";
                mysqli_query($conn, $insertPairingsQuery);

                $roundNumber++;
            }

            // Display success message
            echo "<p>Pairings generated successfully!</p>";
        } else {
            // Display error message if no players found
            echo "<p>No players found.</p>";
        }
    } else {
        // Display error message if no tournament found
        echo "<p>No tournament found.</p>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pairings</title>
</head>

<body>
    <h1>Pairings</h1>

    <form action="" method="post">
        <button type="submit" name="clear_pairings">Clear Pairings</button>
        <button type="submit" name="generate_pairings">Generate Pairings</button>
    </form>

    <?php
    // Display the pairings
    $selectPairingsQuery = "SELECT * FROM pairings";
    $result = mysqli_query($conn, $selectPairingsQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "<h2>Pairings</h2>";
        echo "<table>";
        echo "<tr><th>Player 1</th><th>Player 2</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            $player1FullName = $row['player1_name'];
            $player2FullName = $row['player2_name'];

            echo "<tr><td>$player1FullName</td><td>$player2FullName</td></tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No pairings found.</p>";
    }
    ?>

</body>

</html>