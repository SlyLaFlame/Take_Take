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
$query = "SELECT * FROM round_results WHERE tournament_id = $latestTournamentId ORDER BY round_number";
$result = mysqli_query($conn, $query);

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set the column headers
$sheet->setCellValue('A1', 'Pairing ID');
$sheet->setCellValue('B1', 'Player 1 Name');
$sheet->setCellValue('C1', 'Player 1 Score');
$sheet->setCellValue('D1', 'Player 2 Name');
$sheet->setCellValue('E1', 'Player 2 Score');
$sheet->setCellValue('F1', 'Round Number');

// Fill in the data rows
$row = 2;
while ($roundResult = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $row, $roundResult['pairing_id']);
    $sheet->setCellValue('B' . $row, $roundResult['player1_name']);
    $sheet->setCellValue('C' . $row, $roundResult['player1_score']);
    $sheet->setCellValue('D' . $row, $roundResult['player2_name']);
    $sheet->setCellValue('E' . $row, $roundResult['player2_score']);
    $sheet->setCellValue('F' . $row, $roundResult['round_number']);
    $row++;
}

// Save the spreadsheet as a file
$writer = new Xlsx($spreadsheet);
$writer->save('round_results_report.xlsx');
$downloadLink = 'round_results_report.xlsx';
/* echo "<a href='$downloadLink' download>Download Round Results Report</a>"; */
?>
