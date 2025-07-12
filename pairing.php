<?php
include 'connection.php';
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
$generateButtonDisabled = false;
// Check if the "Generate Pairings" button is clicked
if (isset($_POST['generate_pairings'])) {
    $generateButtonDisabled = true;
    // Retrieve the latest tournament_id from the tournament_details table
    $tournamentQuery = "SELECT tournament_id FROM tournament_details ORDER BY tournament_id DESC LIMIT 1";
    $tournamentResult = mysqli_query($conn, $tournamentQuery);
    $row = mysqli_fetch_assoc($tournamentResult);
    $latestTournamentId = $row['tournament_id'];

    if ($latestTournamentId) {
        // Retrieve the tournament details using the latest tournament_id
        $tournamentQuery = "SELECT * FROM tournament_details WHERE tournament_id = $latestTournamentId";
        $tournamentResult = mysqli_query($conn, $tournamentQuery);

        if ($tournamentResult && mysqli_num_rows($tournamentResult) > 0) {
            $tournament = mysqli_fetch_assoc($tournamentResult);
            $maxRound = $tournament['max_round']; // Retrieve the maximum round number from the tournament details

            // Fetch all players from the database
            $selectPlayersQuery = "SELECT fide_id FROM players WHERE approved=1";
            $result = mysqli_query($conn, $selectPlayersQuery);

            // Create an array to store the players
            $players = array();

            // Check if there are players in the database
            if ($result && mysqli_num_rows($result) > 0) {
                // Store the players in the array
                while ($row = mysqli_fetch_assoc($result)) {
                    $players[] = $row['fide_id'];
                }

                // Calculate the current round based on existing pairings
                $currentRoundQuery = "SELECT round_number FROM pairings WHERE tournament_id = $latestTournamentId ORDER BY round_number DESC LIMIT 1";
                $currentRoundResult = mysqli_query($conn, $currentRoundQuery);
                $currentRound = 1; // Default to Round 1 if no existing pairings found

                if ($currentRoundResult && mysqli_num_rows($currentRoundResult) > 0) {
                    $row = mysqli_fetch_assoc($currentRoundResult);
                    $currentRound = $row['round_number'] + 1; // Increment the current round
                }

                // Check if all rounds have been completed
                if ($currentRound > $maxRound) {
                    echo "<p>All rounds have been completed.</p>";
                } else {
                    // Randomize the order of players
                    shuffle($players);

                    // Generate pairings for the current round
                    $numPlayers = count($players);
                    $roundNumber = $currentRound;

                    for ($i = 0; $i < $numPlayers - 1; $i += 2) {
                        $player1 = $players[$i];
                        $player2 = $players[$i + 1];

                        // Get the full names of players
                        $player1Name = getPlayerFullName($player1, $conn);
                        $player2Name = getPlayerFullName($player2, $conn);

                        // Insert the pairings into the pairings table
                        $insertPairingsQuery = "INSERT INTO pairings (tournament_id, player1_fide_id, player1_name, player2_fide_id, player2_name, round_number) 
                        VALUES ('$latestTournamentId', '$player1', '$player1Name', '$player2', '$player2Name', $roundNumber)";
                        mysqli_query($conn, $insertPairingsQuery);
                    }

                    // Display success message
                    echo "<p>Pairings generated for Round $roundNumber.</p>";
                }
            } else {
                // Display error message if no players found
                echo "<p>No players found.</p>";
            }
        } else {
            // Display error message if no tournament found
            echo "<p>No tournament found.</p>";
        }
    } else {
        // Display error message if no tournament ID provided
        echo "<p>No tournament ID provided.</p>";
    }
}

// Check if the "Submit Results" button is clicked
if (isset($_POST['submit_results'])) {
    $isValid = true; // Variable to track the validation status

    // Iterate over the submitted results and check if any buttons are not selected
    foreach ($_POST['result'] as $pairingId => $resultValue) {
        if (empty($resultValue)) {
            $isValid = false; // Set the validation status to false if any button is not selected
            break; // Exit the loop early as we have already found an empty result
        }
    }

    if ($isValid) {
        // Retrieve the latest tournament_id from the tournament_details table
        $tournamentQuery = "SELECT tournament_id FROM tournament_details ORDER BY tournament_id DESC LIMIT 1";
        $tournamentResult = mysqli_query($conn, $tournamentQuery);
        $row = mysqli_fetch_assoc($tournamentResult);
        $latestTournamentId = $row['tournament_id'];

        if ($latestTournamentId) {
            // Get the current round from the hidden input field
            $currentRound = $_POST['current_round'];

            // Update the results for the current round
            for ($i = 1; $i <= $currentRound; $i++) {
                $roundKey = 'round_' . $i;

                if (isset($_POST[$roundKey]) && is_array($_POST[$roundKey])) {
                    $roundResults = $_POST[$roundKey];

                    foreach ($roundResults as $pairingId => $result) {
                        // Check if the result format is valid
                        if (in_array($result, ['3:0', '0:3', '1:1'])) {
                            // Get the player1 and player2 scores based on the button value
                            $player1Score = 0;
                            $player2Score = 0;

                            if ($result === '3:0') {
                                $player1Score = 3;
                                $player2Score = 0;
                            } elseif ($result === '0:3') {
                                $player1Score = 0;
                                $player2Score = 3;
                            } elseif ($result === '1:1') {
                                $player1Score = 1;
                                $player2Score = 1;
                            }

                            // Update the round_results table with the selected scores
                            $updateResultsQuery = "UPDATE round_results SET player1_score = '$player1Score', player2_score = '$player2Score' WHERE pairing_id = $pairingId AND round_number = $i";
                            mysqli_query($conn, $updateResultsQuery);
                        } else {
                            // Handle the case when the result format is invalid
                            echo "Invalid result format for pairing ID: $pairingId<br>";
                        }
                    }
                }
            }

            // Display success message
            echo "<p>Results updated for Round $currentRound.</p>";
        } else {
            // Display error message if no tournament ID provided
            echo "<p>No tournament ID provided.</p>";
        }
    } else {
        // Display an error message if any button is not selected
        echo "<p>Please select a result for all pairings before submitting.</p>";
    }
}
// Check if the "Pair Next Round" button is clicked
if (isset($_POST['pair_next_round'])) {
    // Retrieve the current round number from the form
    $currentRound = $_POST['current_round'];
    $nextRound = ++$currentRound;

    // Retrieve the latest tournament_id from the round_results table
    $tournamentQuery = "SELECT tournament_id FROM round_results";
    $tournamentResult = mysqli_query($conn, $tournamentQuery);
    $row = mysqli_fetch_assoc($tournamentResult);
    $latestTournamentId = $row['tournament_id'];

    // Include pair-round.php to handle pairing logic for the next round
    include 'pair-round.php';
}

?>




<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    h1 {
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    }

    h2 {
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        font-style: italic;
    }

    p {
        color: blueviolet;
    }
    </style>
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
    function validateForm() {
  var results = document.getElementsByName('result[]');
  var isValid = true;
  
  // Check if any score is not selected
  for (var i = 0; i < results.length; i++) {
    if (results[i].value === '') {
      isValid = false;
      break;
    }
  }
  
  // Enable or disable the submit button based on validation status
  var submitButton = document.getElementById('submitResultsButton');
  submitButton.disabled = !isValid;
  
  if (!isValid) {
    alert('Please select a score for all pairings before submitting.');
  }
}

    </script>



    <title>Pairings</title>
</head>

<body>

    <h1>Pairings</h1>

    <form action="" method="post">
        <button type="submit" name="clear_pairings" class="btn btn-danger">Clear Pairings</button>
        <button type="submit" name="generate_pairings" class="btn btn-success" <?php echo $generateButtonDisabled ? 'disabled' : ''; ?>>
    Pair round 1
</button>
    </form>

    <?php
// Retrieve the latest tournament_id from the tournament_details table
$tournamentQuery = "SELECT tournament_id FROM tournament_details ORDER BY tournament_id DESC LIMIT 1";
$tournamentResult = mysqli_query($conn, $tournamentQuery);
$row = mysqli_fetch_assoc($tournamentResult);
$latestTournamentId = $row['tournament_id'];

// Retrieve the maximum round number from the tournament details
$maxRoundQuery = "SELECT max_round FROM tournament_details WHERE tournament_id = $latestTournamentId";
$maxRoundResult = mysqli_query($conn, $maxRoundQuery);
$row = mysqli_fetch_assoc($maxRoundResult);
$maxRound = $row['max_round'];

// Retrieve the current round number for the ongoing tournament
$currentRoundQuery = "SELECT round_number FROM round_results WHERE tournament_id = $latestTournamentId";
$currentRoundResult = mysqli_query($conn, $currentRoundQuery);
$currentRoundRow = mysqli_fetch_assoc($currentRoundResult);
if (mysqli_num_rows($currentRoundResult) > 0) {
    
    $currentRound = $currentRoundRow['round_number'];
    
} else {
    // first round
    $currentRound = 1;
    
}

// Display the pairings
$selectPairingsQuery = "SELECT * FROM pairings WHERE tournament_id = $latestTournamentId AND round_number = $currentRound";
$result = mysqli_query($conn, $selectPairingsQuery);

if ($result && mysqli_num_rows($result) > 0) {
    echo "<h2>Pairings for (Round $currentRound)</h2>";
    echo "<form action='' method='post' onsubmit='return validateForm()'>";
    echo "<input type='hidden' name='tournament_id' value='$latestTournamentId'>";
    echo "<input type='hidden' name='current_round' value='$currentRound'>";

    echo "<table>";
    echo "<tr><th>Player 1</th><th>Result</th><th>Player 2</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        $pairingId = $row['pairing_id'];
        $player1FullName = $row['player1_name'];
        $player2FullName = $row['player2_name'];
        $resultValue = isset($_POST['result'][$pairingId]) ? $_POST['result'][$pairingId] : '';

        echo "<tr>";
        echo "<td>$player1FullName</td>";
        echo "<td>";
        echo "<input type='hidden' id='result_$pairingId' name='result[$pairingId]' value=''>";
        echo "<button type='button' onclick='updateButton(this, $pairingId, 3, 0)'>3:0</button>";
        echo "<button type='button' onclick='updateButton(this, $pairingId, 1, 1)'>1:1</button>";
        echo "<button type='button' onclick='updateButton(this, $pairingId, 0, 3)'>0:3</button>";
        echo "</td>";
        echo "<td>$player2FullName</td>";
        echo "</tr>";

        // Check if the result is not empty
        if ($resultValue !== '') {
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
                

                // Check if the result already exists in the round_results table
                $checkResultQuery = "SELECT * FROM round_results WHERE pairing_id = $pairingId AND round_number = $currentRound";
                $resultExists = mysqli_query($conn, $checkResultQuery);

                if (mysqli_num_rows($resultExists) > 0) {
                    // Update the round_results table with the selected scores
                    $updateResultsQuery = "UPDATE round_results SET player1_score = '$player1Score', player2_score = '$player2Score' WHERE pairing_id = $pairingId AND round_number = $currentRound";
                    mysqli_query($conn, $updateResultsQuery);
                    if (mysqli_error($conn)) {
                        echo "Error: " . mysqli_error($conn);
                    }
                } else {
                    // Insert the new result into the round_results table
                    $insertResultsQuery = "INSERT INTO round_results 
                    (pairing_id, tournament_id, round_number, player1_name, player1_score, player2_name, player2_score) 
                    VALUES ($pairingId, $latestTournamentId, $currentRound, '$player1FullName', '$player1Score', '$player2FullName', '$player2Score')";
                    mysqli_query($conn, $insertResultsQuery);
                    if (mysqli_error($conn)) {
                        echo "Error: " . mysqli_error($conn);
                    }
                }
            } else {
                // Handle the case when the result format is invalid
                echo "Invalid result format for pairing ID: $pairingId<br>";
            }
        }
    }

    echo "</table>";

    echo "<button type='submit' name='submit_results' id='submitResultsButton' class='btn btn-primary'>Submit Results</button>";

    // Check if all results for the current round have been submitted
    $currentRoundQuery = "SELECT COUNT(*) AS count FROM round_results WHERE tournament_id = $latestTournamentId AND round_number = $currentRound";
    $currentRoundResult = mysqli_query($conn, $currentRoundQuery);
    $row = mysqli_fetch_assoc($currentRoundResult);
    $resultCount = $row['count'];

    if ($resultCount > 0) {
        // Check if it's the last round of the tournament
        if ($currentRound == $maxRound) {
            echo "<p>Tournament finished!</p>";
        }  else {
            // Display the button to pair the next round
          echo"  <form action='pair-round.php' method='post'>";
            echo "<input type='hidden' name='tournament_id' value='$latestTournamentId'>";
           echo" <input type='hidden' name='current_round' value='$currentRound'>";
            echo "<input type='submit' name='pair_next_round' value='Pair Next Round' class= 'btn btn-success'>";
            echo "</form>";
        } 
    } else {
        // Display a message indicating that the current round results need to be submitted first
        echo "<p>Please submit the results for Round $currentRound before proceeding to the next round.</p>";
    }
} else {
    echo "<p>No pairings found for the current round $currentRound.</p>";
}
?>
<br> <br>
<div class="text-start">
<?php
$downloadLink = 'pairing_report.xlsx';
echo "<a href='$downloadLink' download class= 'btn btn-success'>Generate Pairings Report</a>";
?>

</div>

</body>
</html>

<?php
include 'connection.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


 $tournamentQuery = "SELECT tournament_id FROM tournament_details ORDER BY tournament_id DESC LIMIT 1";
 $tournamentResult = mysqli_query($conn, $tournamentQuery);
 $row = mysqli_fetch_assoc($tournamentResult);
 $latestTournamentId = $row['tournament_id'];
$query = "SELECT * FROM pairings WHERE tournament_id = $latestTournamentId ORDER BY round_number";
$result = mysqli_query($conn, $query);

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set the column headers
$sheet->setCellValue('A1', 'Pairing ID');
$sheet->setCellValue('B1', 'Player 1 FIDE ID');
$sheet->setCellValue('C1', 'Player 1 Name');
$sheet->setCellValue('D1', 'Player 2 FIDE ID');
$sheet->setCellValue('E1', 'Player 2 Name');
$sheet->setCellValue('F1', 'Round Number');

// Fill in the data rows
$row = 2;
while ($pairing = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $row, $pairing['pairing_id']);
    $sheet->setCellValue('B' . $row, $pairing['player1_fide_id']);
    $sheet->setCellValue('C' . $row, $pairing['player1_name']);
    $sheet->setCellValue('D' . $row, $pairing['player2_fide_id']);
    $sheet->setCellValue('E' . $row, $pairing['player2_name']);
    $sheet->setCellValue('F' . $row, $pairing['round_number']);
    $row++;
}

// Save the spreadsheet as a file
$writer = new Xlsx($spreadsheet);
$writer->save('pairing_report.xlsx');
$downloadLink = 'pairing_report.xlsx';
/* echo "<a href='$downloadLink' download>Download Pairing Report</a>"; */
?>
