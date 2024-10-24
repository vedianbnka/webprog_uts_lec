<?php
session_start();
require_once '../db.php';

$id_partisipan = $_GET['id_partisipan'];
$sql = "UPDATE list_partisipan_event SET status = 'canceled', no_tiket = null WHERE id_partisipan = ?";
$statement = $db->prepare($sql);
$statement->execute([$id_partisipan]);

$_SESSION['success'] = 'Tiket anda telah di cancel';
header('Location: tiket.php');
?>