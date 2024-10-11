<?php
require_once "../db.php"; // Hubungkan ke database

$id_event = $_GET['id_event'];
$status = $_POST['status'];

$sql = "UPDATE event_konser SET status_event = ? WHERE id_event = ?";
$statement = $db->prepare($sql);
$statement->execute([$status, $id_event]);

header('Location: index.php');