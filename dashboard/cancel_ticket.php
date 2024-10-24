<?php
session_start();
require_once '../db.php';

$id_partisipan = $_GET['id_partisipan'];
$status = 'canceled';
$sql = "SELECT status FROM list_partisipan_event WHERE id_partisipan = ?";
$statement = $db->prepare($sql);
$statement->execute([$id_partisipan]);
$tiket = $statement->fetch(PDO::FETCH_ASSOC);
if($tiket['status'] == 'approved'){
    $_SESSION['error'] = 'Tiket yang sudah di approve tidak bisa di cancel.';
    header('Location: tiket.php');
    exit();
}
if($tiket['status'] == 'event canceled'){
    $_SESSION['error'] = 'Event ini sudah tidak tersedia.';
    header('Location: tiket.php');
    exit();
}

$sql = "UPDATE list_partisipan_event SET status = ?, no_tiket = null WHERE id_partisipan = ?";
$statement = $db->prepare($sql);
$statement->execute([$status, $id_partisipan]);

$_SESSION['success'] = 'Tiket anda telah di cancel';
header('Location: tiket.php');
?>