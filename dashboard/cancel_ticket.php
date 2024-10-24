<?php
session_start();
require_once '../db.php';

$id_partisipan = $_GET['id_partisipan'];
$sql = "UPDATE list_partisipan_event SET status = 'canceled', no_tiket = null WHERE id_partisipan = ?";
$statement = $db->prepare($sql);
$statement->execute([$id_partisipan]);

$sql = "UPDATE tiket SET jumlah_sold = jumlah_sold - (SELECT jumlah FROM list_partisipan_event WHERE id_partisipan = ?) WHERE id_event = (SELECT id_event FROM list_partisipan_event WHERE id_partisipan = ?) AND tipe_tiket = (SELECT tipe_tiket FROM list_partisipan_event WHERE id_partisipan = ?)";
$statement = $db->prepare($sql);
$statement->execute([$id_partisipan, $id_partisipan, $id_partisipan]);

$_SESSION['success'] = 'Tiket anda telah di cancel';
header('Location: tiket.php');
?>