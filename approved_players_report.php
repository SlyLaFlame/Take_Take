<?php
include 'connection.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


// Retrieve player data from the database
$query = "SELECT * FROM players WHERE approved = 1";
$result = mysqli_query($conn, $query);

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
// Add system name
$systemName = 'ChessFlame Tournament Management System';
$sheet->mergeCells('B1:D1');
$sheet->setCellValue('B1', $systemName);
$sheet->getStyle('B1')->getFont()->setSize(20)->setBold(true)->getColor()->setRGB('FF0000');

// Adjust the row height for the column headers
$sheet->getRowDimension(2)->setRowHeight(25);
// Add the logo image
$logoPath = 'images/knightlogo.png'; // Update with the path to your logo file
$logo = new Drawing();
$logo->setName('Logo');
$logo->setDescription('Logo');
$logo->setPath($logoPath);
$logo->setCoordinates('A1');
$logo->setWidth(800);
$logo->setHeight(30);
$logo->setOffsetX(5); // Adjust the horizontal position as needed
$logo->setOffsetY(5); // Adjust the vertical position as needed
$logo->setWorksheet($sheet);


// Set the column headers
$sheet->setCellValue('A4', 'ID');
$sheet->setCellValue('B4', 'First Name');
$sheet->setCellValue('C4', 'Last Name');
$sheet->setCellValue('D4', 'Club');

// Fill in the data rows
$row = 2;
while ($player = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $row, $player['fide_id']);
    $sheet->setCellValue('B' . $row, $player['first_name']);
    $sheet->setCellValue('C' . $row, $player['last_name']);
    $sheet->setCellValue('D' . $row, $player['club']);
    $row++;
}


// Save the spreadsheet as a file
$writer = new Xlsx($spreadsheet);
$writer->save('approved_players_report.xlsx');
$downloadLink = 'approved_players_report.xlsx';
/* echo "<a href='$downloadLink' download>Download approved players Report</a>"; */


