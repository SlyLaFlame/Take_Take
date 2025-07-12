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
echo "<a href='$downloadLink' download>Download Pairing Report</a>";
?>
