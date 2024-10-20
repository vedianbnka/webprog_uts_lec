<?php
require_once "../vendor/autoload.php";
require_once "../db.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$id_event = $_GET['id_event'];
$sql = "SELECT * FROM event_konser WHERE id_event = ?";
$statement = $db->prepare($sql);
$statement->execute([$id_event]);
$event = $statement->fetch(PDO::FETCH_ASSOC);
$nama_event = $event['nama_event'];

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sql = "SELECT * FROM list_partisipan_event AS a JOIN user AS b ON a.id_user = b.id_user WHERE id_event = ?";
$statement = $db->prepare($sql);
$statement->execute([$id_event]);
    $sheet->setCellValue('A1', 'ID Partisipan');
    $sheet->setCellValue('B1', 'ID User');
    $sheet->setCellValue('C1', 'Nama');
    $sheet->setCellValue('D1', 'Email');
    $sheet->setCellValue('E1', 'No. Telp');
    $sheet->setCellValue('F1', 'Tipe Tiket');
    $sheet->setCellValue('G1', 'Jumlah Pembelian');
    $sheet->setCellValue('H1', 'Bukti Pembayaran');
    $sheet->setCellValue('I1', 'Status');
    $sheet->setCellValue('J1', 'No. Tiket');

while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $id_partisipan = $row['id_partisipan'];
    $id_user = $row['id_user'];
    $nama = $row['nama'];
    $email = $row['email'];
    $no_telp = $row['no_telp'];
    $tipe_tiket = $row['tipe_tiket'];
    $jml_pilih = $row['jumlah'];
    $bukti_tf = $row['bukti_pembayaran'];
    $status = $row['status'];
    $no_tiket = $row['no_tiket'];
    $sheet->setCellValue('A' . ($i + 2), $id_partisipan);
    $sheet->setCellValue('B' . ($i + 2), $id_user);
    $sheet->setCellValue('C' . ($i + 2), $nama);
    $sheet->setCellValue('D' . ($i + 2), $email);
    $sheet->setCellValue('E' . ($i + 2), $no_telp);
    $sheet->setCellValue('F' . ($i + 2), $tipe_tiket);
    $sheet->setCellValue('G' . ($i + 2), $jml_pilih);
    $sheet->setCellValue('H' . ($i + 2), $bukti_tf);
    $sheet->setCellValue('I' . ($i + 2), $status);
    $sheet->setCellValue('J' . ($i + 2), $no_tiket);
    $i++;
}

// Prepare to download the file instead of saving it
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$nama_event.'.xlsx"');
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