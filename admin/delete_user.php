<?php
require_once "../db.php"; // Hubungkan ke database

$id_user = $_GET['id_user'];

$sql = "DELETE FROM user WHERE id_user = ?";
$statement = $db->prepare($sql);
$statement->execute([$id_user]);

header('Location: view_user.php');