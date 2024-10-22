<?php
session_start();
require_once "../db.php";

$id_admin = $_GET['id_user'];

$sql = "DELETE FROM admin WHERE id_user = ?";
$statement = $db->prepare($sql);
$statement->execute([$id_admin]);
$_SESSION['success'] = "Admin berhasil dihapus";
header ("location: list_admin.php");