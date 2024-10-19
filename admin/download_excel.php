<?php
require_once "../vendor/autoload.php";
require_once "../db.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Hello World !');
$sheet->setCellValue('A2','Hello UMN');
$sheet->setCellValue('A3','Hello Indonesia');
$sheet->setCellValue('B1','John Thor');
$sheet->setCellValue('B2', 'John Wick');
$sheet->setCellValue('B3','John Doe');

// Prepare to download the file instead of saving it
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="hello.xlsx"');
header('Cache-Control: max-age=0');

// Save the spreadsheet to the output stream for download
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit; // Exit to prevent further execution

// Uncomment if you still need to read the file and output the data
/*
$inputFileType = 'Xlsx';
$inputFileName = __DIR__ .'/hello.xlsx';
$reader = IOFactory::createReader($inputFileType);
$reader->setReadDataOnly(true);
$spreadsheet = $reader->load($inputFileName);
$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
echo "<pre>";
var_dump($sheetData);
*/
?>