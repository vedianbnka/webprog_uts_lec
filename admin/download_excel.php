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

$sheet->setCellValue('A1', 'History Partisipan Event : '.$nama_event);
    $sheet->setCellValue('A2', 'ID Partisipan');
    $sheet->setCellValue('B2', 'ID User');
    $sheet->setCellValue('C2', 'Nama');
    $sheet->setCellValue('D2', 'Email');
    $sheet->setCellValue('E2', 'No. Telp');
    $sheet->setCellValue('F2', 'Tipe Tiket');
    $sheet->setCellValue('G2', 'Jumlah Pembelian');
    $sheet->setCellValue('H2', 'Bukti Pembayaran');
    $sheet->setCellValue('I2', 'Status');
    $sheet->setCellValue('J2', 'No. Tiket');

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
    $sheet->setCellValue('A' . ($i + 3), $id_partisipan);
    $sheet->setCellValue('B' . ($i + 3), $id_user);
    $sheet->setCellValue('C' . ($i + 3), $nama);
    $sheet->setCellValue('D' . ($i + 3), $email);
    $sheet->setCellValue('E' . ($i + 3), $no_telp);
    $sheet->setCellValue('F' . ($i + 3), $tipe_tiket);
    $sheet->setCellValue('G' . ($i + 3), $jml_pilih);
    $sheet->setCellValue('H' . ($i + 3), $bukti_tf);
    $sheet->setCellValue('I' . ($i + 3), $status);
    $sheet->setCellValue('J' . ($i + 3), $no_tiket);
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