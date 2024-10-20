<?php
require_once "../vendor/autoload.php";
require_once "../db.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$id_user = $_GET['id_user'];
$sql = "SELECT * FROM user WHERE id_user = ?";
$statement = $db->prepare($sql);
$statement->execute([$id_user]);
$user = $statement->fetch(PDO::FETCH_ASSOC);
$nama = $user['nama'];

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sql = "SELECT * FROM list_partisipan_event AS p JOIN event_konser AS e ON p.id_event = e.id_event WHERE p.id_user = ? AND p.status = 'approved'";
$statement = $db->prepare($sql);
$statement->execute([$id_user]);
    $sheet->setCellValue('A1', 'History Partisipan User : '.$nama);
   $sheet->setCellValue('A2', 'Nama Event');
   $sheet->setCellValue('B2', 'Tanggal Register');
   $sheet->setCellValue('C2', 'Tipe Tiket');
   $sheet->setCellValue('D2', 'Jumlah Pembelian Tiket');
   $sheet->setCellValue('E2', 'No. Tiket');
   $i = 3;
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
   $sheet->setCellValue('A'.$i, $row['nama_event']);
   $sheet->setCellValue('B'.$i, $row['tanggal_register']);
   $sheet->setCellValue('C'.$i, $row['tipe_tiket']);
   $sheet->setCellValue('D'.$i, $row['jumlah']);
   $sheet->setCellValue('E'.$i, $row['no_tiket']);
   $i++;
}

// Prepare to download the file instead of saving it
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="history_partisipan_'.$nama.'.xlsx"');
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