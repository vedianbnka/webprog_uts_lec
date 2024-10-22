<?php
// Pastikan library phpqrcode sudah ada
include "phpqrcode/qrlib.php"; 
require_once 'db.php';
$sql = "SELECT * FROM list_partisipan_event WHERE id_partisipan = ?";
$statement = $db->prepare($sql);
$statement->execute([$_GET['id_partisipan']]);
$row = $statement->fetch(PDO::FETCH_ASSOC);

// Set header agar output dikenali sebagai image PNG
header('Content-Type: image/png');

// Isi QR code yang ingin dibuat
$isi = $row['no_tiket']; 

// Buat QR code dan tampilkan
QRcode::png($isi); 
?>