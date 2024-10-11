<?php
require_once "../db.php";

$id_event = $_GET['id_event'];

$sql = "DELETE FROM event_konser WHERE id_event = ?";
$statement = $db->prepare($sql);
$statement->execute([$id_event]);

header('Location: index.php');