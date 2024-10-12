<?php
require_once '../db.php';

if (isset($_POST['tipe_tiket'])) {
    $tipe_tiket = $_POST['tipe_tiket'];

    // Query untuk mengambil harga berdasarkan tipe tiket
    $sql = "SELECT harga FROM tiket WHERE tipe_tiket = :tipe_tiket";
    $stmt = $db->prepare($sql);
    $stmt->execute(['tipe_tiket' => $tipe_tiket]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo json_encode(['harga' => $result['harga']]);
    } else {
        echo json_encode(['harga' => 0]);
    }
}