<?php
include 'connection.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


// Retrieve player data from the database
$query = "SELECT * FROM players";
$result = mysqli_query($conn, $query);

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set the column headers
$sheet->setCellValue('A3', 'ID');
$sheet->setCellValue('B3', 'First Name');
$sheet->setCellValue('C3', 'Last Name');
$sheet->setCellValue('D3', 'Club');

// Fill in the data rows
$row = 2;
while ($player = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $row, $player['fide_id']);
    $sheet->setCellValue('B' . $row, $player['first_name']);
    $sheet->setCellValue('C' . $row, $player['last_name']);
    $sheet->setCellValue('D' . $row, $player['club']);
    $row++;
}
// Add system name
$systemName = 'ChessFlame Tournament Management System';
$sheet->mergeCells('A1:D1');
$sheet->setCellValue('A1', $systemName);
$sheet->getStyle('A1')->getFont()->setSize(20)->setBold(true)->getColor()->setRGB('FF0000');
// Save the spreadsheet as a file
$writer = new Xlsx($spreadsheet);
$writer->save('registered_players_report.xlsx');
$downloadLink = 'registered_players_report.xlsx';
echo "<a href='$downloadLink' download>Download Players Report</a>";

$query = "SELECT * FROM players WHERE club = 'KENYATTA UNIVERSITY' ";
