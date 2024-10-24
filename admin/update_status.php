<?php
require_once "../db.php"; // Hubungkan ke database

$id_event = $_GET['id_event'];
$status = $_POST['status'];

$sql = "UPDATE event_konser SET status_event = ? WHERE id_event = ?";
$statement = $db->prepare($sql);
$statement->execute([$status, $id_event]);
if ($status == "canceled") {
    $sql = "UPDATE list_partisipan_event SET status = ? , no_tiket = null WHERE id_event = ?";
    $statement = $db->prepare($sql); 
    $statement->execute(['event canceled', $id_event]);
    $sql = "UPDATE tiket SET jumlah_sold = 0 WHERE id_event = ?";
    $statement = $db->prepare($sql);
    $statement->execute([$id_event]);
}
if ($status == "open") {
    $sql = "UPDATE list_partisipan_event SET status = ? WHERE id_event = ?";
    $statement = $db->prepare($sql);
    $statement->execute(['pending', $id_event]);
}



header('Location: index.php');