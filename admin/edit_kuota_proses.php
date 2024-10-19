<?php
session_start();
require_once "../db.php";

$id_event = $_GET['id_event'];

// Mengambil data dari form
$kuota1 = $_POST['kuota_CAT1'];
$kuota2 = $_POST['kuota_CAT2'];
$kuota3 = $_POST['kuota_CAT3'];
$kuotavvip = $_POST['kuota_VVIP'];
$kuotavip = $_POST['kuota_VIP'];

$pesan = [];
echo $kuota1 . $kuota2 . $kuota3 . $kuotavvip . $kuotavip;

// Cek setiap kuota dan lakukan update jika ada perubahan
if (isset($kuota1)) {
    $sql = "UPDATE tiket SET kuota = ? WHERE id_event = ? AND tipe_tiket = 'CAT 1';";
    $stmt = $db->prepare($sql);
    $stmt->execute([$kuota1, $id_event]);
    $pesan[] = 'CAT 1 sebanyak ' . $kuota1;

}
if (isset($kuota2)) {
    $sql = "UPDATE tiket SET kuota = ? WHERE id_event = ? AND tipe_tiket = 'CAT 2';";
    $stmt = $db->prepare($sql);
    $stmt->execute([$kuota2, $id_event]);
    $pesan[] = 'CAT 2 sebanyak ' . $kuota2;
}
if (isset($kuota3)) {
    $sql = "UPDATE tiket SET kuota= ? WHERE id_event = ? AND tipe_tiket = 'CAT 3';";
    $stmt = $db->prepare($sql);
    $stmt->execute([$kuota3, $id_event]);
    $pesan[] = 'CAT 3 sebanyak ' . $kuota3;
}
if (isset($kuotavvip)) {
    $sql = "UPDATE tiket SET kuota = ? WHERE id_event = ? AND tipe_tiket = 'VVIP';";
    $stmt = $db->prepare($sql);
    $stmt->execute([$kuotavvip, $id_event]);
    $pesan[] = 'VVIP sebanyak ' . $kuotavvip;
}
if (isset($kuotavip)) {
    $sql = "UPDATE tiket SET kuota = ? WHERE id_event = ? AND tipe_tiket = 'VIP';";
    $stmt = $db->prepare($sql);
    $stmt->execute([$kuotavip, $id_event]);
    $pesan[] = 'VIP sebanyak ' . $kuotavip;
}
// Jika ada pesan yang terkumpul, gabungkan pesan
if (!empty($pesan)) {
    $_SESSION['success'] = 'Berhasil mengubah kuota: ' . implode(', ', $pesan) . '.';
} else {
    $_SESSION['success'] = 'Tidak ada perubahan kuota tiket.';
}

// Redirect ke halaman index
header('Location: index.php');
exit();