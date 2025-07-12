<?php
include 'connection.php';
include 'navbar-user.php';

// Retrieve the latest tournament_id from the tournament_details table
$tournamentQuery = "SELECT tournament_id FROM tournament_details ORDER BY tournament_id DESC LIMIT 1";
$tournamentResult = mysqli_query($conn, $tournamentQuery);
$row = mysqli_fetch_assoc($tournamentResult);
$latestTournamentId = $row['tournament_id'];


// Retrieve the pairings for the current round
$selectPairingsQuery = "SELECT * FROM pairings WHERE tournament_id = $latestTournamentId";
$result = mysqli_query($conn, $selectPairingsQuery);
$currentRound=1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pairings</title>
    <style>
        h3
        {
            color: red;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
<?php
if ($result && mysqli_num_rows($result) > 0) {
    // Group the pairings by round number
    $pairingsByRound = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $roundNumber = $row['round_number'];
        if (!isset($pairingsByRound[$roundNumber])) {
            $pairingsByRound[$roundNumber] = array();
        }
        $pairingsByRound[$roundNumber][] = $row;
    }

    // Display pairings for each round
    foreach ($pairingsByRound as $roundNumber => $pairings) {
        echo "<h2>Pairings (Round $roundNumber)</h2>";
        echo "<table>";
        echo "<tr><th>Player 1</th><th>Player 2</th></tr>";
        foreach ($pairings as $row) {
            $player1FullName = $row['player1_name'];
            $player2FullName = $row['player2_name'];

            echo "<tr>";
            echo "<td>$player1FullName</td>";
            echo "<td>$player2FullName</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
} else {
    echo "<p>No pairings available.</p>";
}
?>

    
    
   <?php
    // Retrieve the latest tournament_id from the tournament_details table
$tournamentQuery = "SELECT tournament_id FROM tournament_details ORDER BY tournament_id DESC LIMIT 1";
$tournamentResult = mysqli_query($conn, $tournamentQuery);
$row = mysqli_fetch_assoc($tournamentResult);
$latestTournamentId = $row['tournament_id'];

 // Check if the result already exists in the round_results table
 $checkResultQuery = "SELECT * FROM round_results";
 $resultExists = mysqli_query($conn, $checkResultQuery);
 if (mysqli_num_rows($resultExists) > 0) {
   


// Retrieve the current round number for the ongoing tournament
$currentRoundQuery = "SELECT round_number FROM round_results WHERE tournament_id = $latestTournamentId";
$currentRoundResult = mysqli_query($conn, $currentRoundQuery);
$currentRoundRow = mysqli_fetch_assoc($currentRoundResult);
$currentRound = $currentRoundRow['round_number'];


// Retrieve the round results for the current round
$selectResultsQuery = "SELECT player1_name, player1_score, player2_name, player2_score FROM round_results WHERE tournament_id = $latestTournamentId";
$result = mysqli_query($conn, $selectResultsQuery);
?>
<?php

// Retrieve the latest tournament_id from the tournament_details table
$tournamentQuery = "SELECT tournament_id FROM tournament_details ORDER BY tournament_id DESC LIMIT 1";
$tournamentResult = mysqli_query($conn, $tournamentQuery);
$row = mysqli_fetch_assoc($tournamentResult);
$latestTournamentId = $row['tournament_id'];

// Retrieve the results for the current round
$selectResultsQuery = "SELECT * FROM round_results WHERE tournament_id = $latestTournamentId";
$result = mysqli_query($conn, $selectResultsQuery);
$currentRound = 1;
if ($result && mysqli_num_rows($result) > 0) {
        // Group the results by round number
        $resultsByRound = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $roundNumber = $row['round_number'];
            if (!isset($resultsByRound[$roundNumber])) {
                $resultsByRound[$roundNumber] = array();
            }
            $resultsByRound[$roundNumber][] = $row;
        }

        // Display results for each round
        foreach ($resultsByRound as $roundNumber => $results) {
            echo "<h2>Round Results (Round $roundNumber)</h2>";
            echo "<table>";
            echo "<tr><th>Player 1</th><th>Player 1 Score</th><th>Player 2</th><th>Player 2 Score</th></tr>";
            foreach ($results as $row) {
                $player1Name = $row['player1_name'];
                $player1Score = $row['player1_score'];
                $player2Name = $row['player2_name'];
                $player2Score = $row['player2_score'];

                echo "<tr>";
                echo "<td>$player1Name</td>";
                echo "<td>$player1Score</td>";
                echo "<td>$player2Name</td>";
                echo "<td>$player2Score</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    } else {
        echo "<p>No round results available.</p>";
    }}
?>
</body>

</html>

<?php
include 'footer.php';
?>

