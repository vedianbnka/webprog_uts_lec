<?php
require_once "../db.php";

$id_event = $_GET['id_event'];



$sql = "SELECT * FROM event_konser WHERE id_event = ?";
$statement = $db->prepare($sql);
$statement->execute([$id_event]);
$event = $statement->fetch(PDO::FETCH_ASSOC);

if ($event) { // Pastikan ada data yang dikembalikan
    $file_path = "../upload/" . $event['banner_event'];
    if (file_exists($file_path)) {
        unlink($file_path);
    }
}

$sql = "DELETE FROM event_konser WHERE id_event = ?";
$statement = $db->prepare($sql);
$statement->execute([$id_event]);
$_SESSION['success'] = 'Berhasil menghapus event.';
header('Location: index.php');