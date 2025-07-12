<?php
include 'connection.php';


function findSimilarScorePlayer($ranking, $player1Index, $pairedPlayers) {
    $totalPlayers = count($ranking);
    $player1Score = $ranking[$player1Index]['total_score'];

    // Find a player with a similar score who has not been paired
    for ($i = $player1Index + 1; $i < $totalPlayers; $i++) {
        $player2Score = $ranking[$i]['total_score'];

        // Check if the player has already been paired
        if (in_array($ranking[$i]['player_name'], $pairedPlayers)) {
            continue;
        }

        // Check if the player has a similar score and is not the same player
        if (abs($player2Score - $player1Score) <= 1 && $ranking[$i]['player_name'] !== $ranking[$player1Index]['player_name']) {
            return $i;
        }
    }

    // If no similar score player is found, find the next available player with lower scores
    for ($i = $player1Index - 1; $i >= 0; $i--) {
        // Check if the player has already been paired
        if (in_array($ranking[$i]['player_name'], $pairedPlayers)) {
            continue;
        }

        return $i;
    }

    // If no suitable player is found, find the next available player with higher scores
    for ($i = $player1Index + 1; $i < $totalPlayers; $i++) {
        // Check if the player has already been paired
        if (in_array($ranking[$i]['player_name'], $pairedPlayers)) {
            continue;
        }

        return $i;
    }
}

if (isset($_REQUEST['current_round'])) {
    $currentRound = $_REQUEST['current_round'];
    $nextRound = $currentRound ++;

    // Retrieve the tournament_id from the round_results table
    $tournamentQuery = "SELECT tournament_id FROM round_results";
    $tournamentResult = mysqli_query($conn, $tournamentQuery);
    $row = mysqli_fetch_assoc($tournamentResult);
    $latestTournamentId = $row['tournament_id'];

    // Retrieve the current round number for the ongoing tournament
    $currentRoundQuery = "SELECT round_number FROM round_results WHERE tournament_id = $latestTournamentId";
    $currentRoundResult = mysqli_query($conn, $currentRoundQuery);
    $currentRoundRow = mysqli_fetch_assoc($currentRoundResult);
    $currentRound = $currentRoundRow['round_number'];
    $nextRound = $currentRound + 1;
    
    

    // Retrieve the ranking after the previous round
    $rankingQuery = "
        SELECT player_name, SUM(total_score) AS total_score
        FROM (
            SELECT player1_name AS player_name, SUM(player1_score) AS total_score
            FROM round_results
            WHERE tournament_id = $latestTournamentId AND round_number = $currentRound
            GROUP BY player1_name
            UNION ALL
            SELECT player2_name AS player_name, SUM(player2_score) AS total_score
            FROM round_results
            WHERE tournament_id = $latestTournamentId AND round_number = $currentRound
            GROUP BY player2_name
        ) AS scores
        GROUP BY player_name
        ORDER BY total_score DESC";

    $rankingResult = mysqli_query($conn, $rankingQuery);

    // Store the ranking in an array
    $ranking = array();
    while ($row = mysqli_fetch_assoc($rankingResult)) {
        $playerName = $row['player_name'];
        $totalScore = $row['total_score'];
        $ranking[] = array('player_name' => $playerName, 'total_score' => $totalScore);
    }

    // Generate pairings for the next round based on the ranking
    $pairings = array();
    $totalPlayers = count($ranking);

    // Create a temporary array to store the already paired players
    $pairedPlayers = array();

    // Pair players with similar scores, avoiding repeated pairings
    for ($i = 0; $i < $totalPlayers; $i++) {
        $player1Index = $i;
        $player1Name = $ranking[$player1Index]['player_name'];

        // Check if the player has already been paired
        if (in_array($player1Name, $pairedPlayers)) {
            continue;
        }

        $player2Index = findSimilarScorePlayer($ranking, $player1Index, $pairedPlayers);
        $player2Name = $ranking[$player2Index]['player_name'];
        // Add the paired players to the temporary array
        $pairedPlayers[] = $player1Name;
        $pairedPlayers[] = $player2Name;

        $pairings[] = array('player1' => $player1Name, 'player2' => $player2Name);

        // Retrieve player1_fide_id and player2_fide_id from the players table
        $getPlayerFideIdQuery = "SELECT fide_id FROM players WHERE CONCAT(first_name, ' ', last_name) = '$player1Name'";
        $player1FideIdResult = mysqli_query($conn, $getPlayerFideIdQuery);
        $player1FideIdRow = mysqli_fetch_assoc($player1FideIdResult);
        $player1FideId = $player1FideIdRow['fide_id'];

        $getPlayerFideIdQuery = "SELECT fide_id FROM players WHERE CONCAT(first_name, ' ', last_name) = '$player2Name'";
        $player2FideIdResult = mysqli_query($conn, $getPlayerFideIdQuery);
        $player2FideIdRow = mysqli_fetch_assoc($player2FideIdResult);
        $player2FideId = $player2FideIdRow['fide_id'];

        // Insert the pairings into the pairings table
        $insertPairingsQuery = "INSERT INTO pairings (tournament_id, player1_fide_id, player1_name, player2_fide_id, player2_name, round_number) 
        VALUES ('$latestTournamentId', '$player1FideId', '$player1Name', '$player2FideId', '$player2Name',$nextRound)";
        mysqli_query($conn, $insertPairingsQuery);
    }

    // Display the pairings for the next round
    echo "<h2>Pairings for Round " . ($nextRound) . "</h2>";
    echo "<form action='pair-round.php' method='post'>";
    echo "<input type='hidden' name='current_round' value='$nextRound'>";
    echo "<input type='hidden' name='tournament_id' value='$latestTournamentId'>";
    echo "<input type='hidden' name='round_number' value='" . ($nextRound) . "'>";
    echo "<table>";
    echo "<tr><th>Player 1</th><th>Result</th><th>Player 2</th></tr>";
    $selectPairingsQuery = "SELECT * FROM pairings WHERE tournament_id = $latestTournamentId AND round_number = $nextRound";
$result = mysqli_query($conn, $selectPairingsQuery);


    while ($row = mysqli_fetch_assoc($result)) {
        $pairingId = $row['pairing_id'];
        $player1 = $row['player1_name'];
        $player2 = $row['player2_name'];
        $resultValue = isset($_POST['result'][$pairingId]) ? $_POST['result'][$pairingId] : '';

        echo "<tr>";
        echo "<td>$player1</td>";
        echo "<td>";
        echo "<input type='hidden' id='result_$pairingId' name='result[$pairingId]' value=''>";
        echo "<button type='button' onclick='updateButton(this, $pairingId, 3, 0)'>3:0</button>";
        echo "<button type='button' onclick='updateButton(this, $pairingId, 0, 3)'>0:3</button>";
        echo "<button type='button' onclick='updateButton(this, $pairingId, 1, 1)'>1:1</button>";
        echo "</td>";
        echo "<td>$player2</td>";
        echo "</tr>";
        
    }
    echo "</table>";
    echo "<br>";
    echo "<input type='submit' name='save_results' value='Save Results'>";
    echo "</form>";
    // Check if the form is submitted and handle result submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_results'])) {
        $results = $_POST['result'];

        foreach ($results as $pairingId => $resultValue) {
            // Check if the result format is valid
            if (in_array($resultValue, ['3:0', '0:3', '1:1'])) {
                // Get the player1 and player2 scores based on the button value
                $player1Score = 0;
                $player2Score = 0;

                if ($resultValue === '3:0') {
                    $player1Score = 3;
                    $player2Score = 0;
                } elseif ($resultValue === '0:3') {
                    $player1Score = 0;
                    $player2Score = 3;
                } elseif ($resultValue === '1:1') {
                    $player1Score = 1;
                    $player2Score = 1;
                }
// Get the player names from the pairings table
$getPlayerNamesQuery = "SELECT player1_name, player2_name FROM pairings WHERE pairing_id = $pairingId";
$getPlayerNamesResult = mysqli_query($conn, $getPlayerNamesQuery);
$playerNames = mysqli_fetch_assoc($getPlayerNamesResult);
$player1 = $playerNames['player1_name'];
$player2 = $playerNames['player2_name'];
                // Check if the result already exists in the round_results table
                $checkResultQuery = "SELECT * FROM round_results WHERE pairing_id = $pairingId AND round_number = $nextRound";
                $resultExists = mysqli_query($conn, $checkResultQuery);

                if (mysqli_num_rows($resultExists) > 0) {
                    // Update the round_results table with the selected scores
                    $updateResultQuery = "UPDATE round_results SET player1_score = $player1Score, player2_score = $player2Score WHERE pairing_id = $pairingId AND round_number = $nextRound";
                    mysqli_query($conn, $updateResultQuery);
                } else {
                    // Insert the new result into the round_results table
$insertResultsQuery = "INSERT INTO round_results 
(pairing_id, tournament_id, round_number, player1_name, player1_score, player2_name, player2_score) 
VALUES ($pairingId, $latestTournamentId, $nextRound, '$player1', '$player1Score', '$player2', '$player2Score')";
mysqli_query($conn, $insertResultsQuery);

                }
            }
        }
       

        echo "<p>Results submitted successfully!</p>";
        
    }

   
} else {
    echo "<p>There are no pairings available for the next round.</p>";
}
 // Display the button to pair the next round
 echo"  <form action='pair-round.php' method='post'>";
 echo "<input type='hidden' name='tournament_id' value='$latestTournamentId'>";
echo" <input type='hidden' name='current_round' value='<?php echo $currentRound; ?>'>";
 echo "<input type='submit' name='pair_next_round' value='Pair Next Round'>";
 echo "</form>";
 
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script>
    function updateButton(button, pairingId, player1Score, player2Score) {
        var row = button.parentNode.parentNode;
        var buttons = row.getElementsByTagName('button');

        // Reset the style of all buttons in the row
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].className = "btn btn-primary";
        }

        // Set the style of the selected button
        button.className = "btn btn-success";

        // Set the hidden input value
        var hiddenInput = document.getElementById("result_" + pairingId);
        hiddenInput.value = player1Score + ":" + player2Score;
    }
    </script>
</head>
</html>