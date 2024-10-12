<?php
session_start();
require_once '../db.php'; // Adjust the path if necessary

// Check if the user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header('Location: ../login/index.php');
//     exit();
// }

if (isset($_POST['id_event'])) {
    $id_event = (int)$_POST['id_event'];
    $jumlah_tiket = (int)$_POST['jumlah_tiket'];
    $tipe_tiket = $_POST['tipe_tiket'];
    $id_user = $_SESSION['id_user'];
    $file_name = $_FILES['bukti_pembayaran']['name'];
    $file_tmp = $_FILES['bukti_pembayaran']['tmp_name'];
    var_dump($_FILES);


    // Mengambil ekstensi file dengan aman
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $file_ext = strtolower($file_ext);  // Mengubah ekstensi menjadi huruf kecil

    // Menentukan ekstensi file yang diperbolehkan
    $allowed_ext = ['jpg', 'jpeg', 'png', 'svg', 'webp', 'bmp', 'gif', 'heic'];

    // Mengecek apakah ekstensi file valid
    if (in_array($file_ext, $allowed_ext)) {
        // Jika valid, pindahkan file ke folder upload
        move_uploaded_file($file_tmp, '../bukti_pembayaran/'.$file_name);
    } else {
        $_SESSION['error'] = 'File Type not supported';
        // header('Location: regis.php?id_event=' . $id_event);
        exit(); // Menghentikan eksekusi kode lebih lanjut
    }

    $sqll = "SELECT * FROM tiket WHERE id_event = $id_event";
                        $result = $db->query($sqll);
                        $kuota = 0;
                        $jumlah_sold = 0;
                        while ($roww = $result->fetch(PDO::FETCH_ASSOC)) {
                            $jumlah_sold += $roww['jumlah_sold'];
                            $kuota += $roww['kuota'];
                        }

    // Fetch the event details
    
    $sql = "INSERT INTO list_partisipan_event(id_user, id_event, tipe_tiket, jumlah, bukti_pembayaran) VALUES (?,?,?,?,?)";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id_user,$id_event, $tipe_tiket, $jumlah_tiket, $file_name]);

    // Check if there are enough tickets available
    if ($jumlah_tiket > ($kuota - $jumlah_sold)) {
        $_SESSION['error'] = 'Tiket yang tersedia hanya ' . ($kuota - $jumlah_sold) . ' tiket.';
        header('Location: regis.php?id_event=' . $id_event);
        exit();
    }

    $sql = "UPDATE tiket SET jumlah_sold = ? WHERE id_event = ? AND tipe_tiket = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$jumlah_tiket, $id_event, $tipe_tiket]);

    // Register the user for the event and update the participant count
    // Registration success
    $_SESSION['success'] = 'Successfully registered with ' . $jumlah_tiket . ' tickets!';
    header('Location: index.php');
    exit();
} else {
    // No event ID provided
    header('Location: index.php');
    exit();
}
