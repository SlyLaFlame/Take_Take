<?php

include 'connection.php';
include 'navbar.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Create a new Excel spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set the headers for each column
$sheet->setCellValue('A1', 'Rank');
$sheet->setCellValue('B1', 'Player Name');
$sheet->setCellValue('C1', 'Total Score');

// Retrieve the latest tournament_id from the tournament_details table
$tournamentQuery = "SELECT tournament_id FROM tournament_details ORDER BY tournament_id DESC LIMIT 1";
$tournamentResult = mysqli_query($conn, $tournamentQuery);
$row = mysqli_fetch_assoc($tournamentResult);
$latestTournamentId = $row['tournament_id'];

// Calculate the accumulated scores for each player
$calculateScoresQuery = "
    SELECT player_name, SUM(total_score) AS total_score
    FROM (
        SELECT player1_name AS player_name, SUM(player1_score) AS total_score
        FROM round_results
        WHERE tournament_id = $latestTournamentId
        GROUP BY player1_name

        UNION ALL

        SELECT player2_name AS player_name, SUM(player2_score) AS total_score
        FROM round_results
        WHERE tournament_id = $latestTournamentId
        GROUP BY player2_name
    ) AS scores
    GROUP BY player_name
    ORDER BY total_score DESC";

$result = mysqli_query($conn, $calculateScoresQuery);

$rank = 1;
$rowNumber = 2; // Start from row 2 to leave room for headers
while ($row = mysqli_fetch_assoc($result)) {
    $playerName = $row['player_name'];
    $totalScore = $row['total_score'];
    $sheet->setCellValue('A' . $rowNumber, $rank);
    $sheet->setCellValue('B' . $rowNumber, $playerName);
    $sheet->setCellValue('C' . $rowNumber, $totalScore);
    $rank++;
    $rowNumber++;
}

// Save the Excel file
$writer = new Xlsx($spreadsheet);
$filename = 'rankings.xlsx';
$writer->save($filename);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <style>
    h1 {
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    }

    p {
        color: blueviolet;
    }

    .center-table {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        max-width: 800px;
        margin: 0 auto;
        margin-top: 150px;
        margin-bottom: 150px;
    }

    .card-body {
        background-color: burlywood;
    }
    </style>
    <title>Rankings</title>
</head>

<body>
    <div class="resultscontent">
        <div class="center-table">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Rankings</h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Rank</th>
                                <th scope="col">Player Name</th>
                                <th scope="col">Total Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Display the data from the spreadsheet
                            $highestRow = $sheet->getHighestRow();
                            for ($row = 2; $row <= $highestRow; $row++) {
                                $rank = $sheet->getCell('A' . $row)->getValue();
                                $playerName = $sheet->getCell('B' . $row)->getValue();
                                $totalScore = $sheet->getCell('C' . $row)->getValue();

                                echo "<tr>";
                                echo "<td>$rank</td>";
                                echo "<td>$playerName</td>";
                                echo "<td>$totalScore</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-center">
        <a href="<?php echo $filename; ?>" class="btn btn-primary btn-lg">Generate rank report (.xlsx)</a>
    </div>

</body>
</html>
<?php 
include 'round_results_report.php';
?>
<div class="text-end">
<?php
$downloadLink = 'round_results_report.xlsx';
echo "<a href='$downloadLink' download class= 'btn btn-success'>Generate results Report</a>";
?> 
<br> <br>
<?php
include 'footer.php';
?>
