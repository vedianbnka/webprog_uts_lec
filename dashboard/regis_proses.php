<?php
session_start();
require_once "../db.php";

// Cek jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $id_user = $_POST['id_user'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $id_event = $_POST['id_event'];
    $jenis_tiket = $_POST['jenis_tiket'];
    $jumlah_tiket = $_POST['jumlah_tiket'];

    // Masukkan data ke tabel list_partisipan_event
    $sql = "INSERT INTO list_partisipan_event (id_user, id_event) VALUES (:id_user, :id_event)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id_user', $id_user);
    $stmt->bindParam(':id_event', $id_event);

    if ($stmt->execute()) {
        // Jika sukses, tampilkan pesan sukses
        echo "Registrasi tiket berhasil untuk event ID: " . htmlspecialchars($id_event);
        echo "<br>Nama: " . htmlspecialchars($nama);
        echo "<br>Email: " . htmlspecialchars($email);
        echo "<br>Telepon: " . htmlspecialchars($phone);
        echo "<br>Jenis Tiket: " . htmlspecialchars($jenis_tiket);
        echo "<br>Jumlah Tiket: " . htmlspecialchars($jumlah_tiket);
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Terjadi kesalahan saat registrasi tiket.";
    }
}
?>
