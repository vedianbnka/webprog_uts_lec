<?php
    session_start();
    require_once "../db.php";

    // Mengambil data dari form
    $nama_event = $_POST['nama_event'];
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];
    $lokasi = $_POST['lokasi'];
    $deskripsi = $_POST['deskripsi'];
    $file_name = $_FILES['banner_event']['name'];
    $file_tmp = $_FILES['banner_event']['tmp_name'];
    $id_event = $_GET['id_event'];

    $sqll = "SELECT * FROM event_konser WHERE id_event = ?";
    $stmtt = $db->prepare($sqll);
    $stmtt->execute([$id_event]);
    $event = $stmtt->fetch();

    $gambar_sebelum = $event['banner_event'];
    $file_path = "../upload/" . $gambar_sebelum;
    

// Cek apakah file tersebut ada


    // Mengambil ekstensi file dengan aman
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $file_ext = strtolower($file_ext);  // Mengubah ekstensi menjadi huruf kecil

    // Menentukan ekstensi file yang diperbolehkan
    $allowed_ext = ['jpg', 'jpeg', 'png', 'svg', 'webp', 'bmp', 'gif', 'heic'];

    // Mengecek apakah ekstensi file valid
    if (in_array($file_ext, $allowed_ext)) {
        // Jika valid, pindahkan file ke folder upload
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        move_uploaded_file($file_tmp, '../upload/'.$file_name);
    } else {
        // Jika ekstensi tidak valid, redirect ke halaman error
        $_SESSION['error'] = 'File type not supported';
        header('Location: edit_event.php?id_event=' . $id_event);
        exit();  // Menghentikan eksekusi kode lebih lanjut
    }
    

    // Query untuk memasukkan data ke database
    $sql = "UPDATE event_konser SET nama_event = ?, tanggal = ?, waktu = ?, lokasi = ?, deskripsi = ?,  banner_event = ? WHERE id_event = ?";
    $stmt = $db->prepare($sql);
    $data = [$nama_event, $tanggal, $waktu, $lokasi, $deskripsi, $file_name, $id_event];
    var_dump($data);
    $stmt->execute($data);

    // Redirect ke halaman admin setelah sukses
    $_SESSION['success'] = 'Berhasil mengedit event.';
    header('Location: ../admin/index.php');
?>