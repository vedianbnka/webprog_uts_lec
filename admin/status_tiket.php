<?php

require_once "../db.php"; // Hubungkan ke database

$id_event = $_GET['id_event'];
$status = $_POST['status'];
$id_partisipan = $_GET['id_partisipan'];

// Validasi dan filter input
$status = htmlspecialchars($status, ENT_QUOTES);
$id_partisipan = (int) $id_partisipan; // Pastikan id_partisipan adalah integer

// Debugging: Tampilkan status dan id_partisipan
var_dump($status);
var_dump($id_partisipan);

// Update status partisipan
$sql = "UPDATE list_partisipan_event SET status = ? WHERE id_partisipan = ?";
$statement = $db->prepare($sql);
if (!$statement->execute([$status, $id_partisipan])) {
    // Jika ada kesalahan, tampilkan error
    print_r($statement->errorInfo());
}

// Periksa status untuk menghasilkan no_tiket jika status approved
if ($status === 'approved') {
    $no_tiket = bin2hex(random_bytes(20));

    // Update no_tiket untuk partisipan
    $sql = "UPDATE list_partisipan_event SET no_tiket = ? WHERE id_partisipan = ?";
    $statement = $db->prepare($sql);
    if (!$statement->execute([$no_tiket, $id_partisipan])) {
        // Jika ada kesalahan, tampilkan error
        print_r($statement->errorInfo());
    }
}
if ($status === 'rejected' || $status === 'pending') {
    $sql = "UPDATE list_partisipan_event SET no_tiket = NULL WHERE id_partisipan = ?";
    $statement = $db->prepare($sql);
    $statement->execute([$id_partisipan]);
}

$sql = "UPDATE tiket
SET jumlah_sold = (
    SELECT SUM(le.jumlah)
    FROM list_partisipan_event le
    WHERE le.id_event = tiket.id_event
      AND le.tipe_tiket = tiket.tipe_tiket
      AND le.status = 'approved'
)
WHERE EXISTS (
    SELECT 1
    FROM list_partisipan_event le
    WHERE le.id_event = tiket.id_event
)";

$statement = $db->prepare($sql);
$statement->execute();

// Alihkan ke halaman list peserta
header('Location: list_peserta.php?id_event=' . $id_event);
exit; // Hentikan eksekusi skrip setelah redirect
?>