<?php
    require_once "../db.php";

    // Mengambil data dari form
    $nama_event = $_POST['nama_event'];
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];
    $lokasi = $_POST['lokasi'];
    $deskripsi = $_POST['deskripsi'];
    $jumlah_max_partisipan = $_POST['jumlah_max_partisipan'];
    $file_name = $_FILES['banner_event']['name'];
    $file_tmp = $_FILES['banner_event']['tmp_name'];

    // Mengambil ekstensi file dengan aman
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $file_ext = strtolower($file_ext);  // Mengubah ekstensi menjadi huruf kecil

    // Menentukan ekstensi file yang diperbolehkan
    $allowed_ext = ['jpg', 'jpeg', 'png', 'svg', 'webp', 'bmp', 'gif', 'heic'];

    // Mengecek apakah ekstensi file valid
    if (in_array($file_ext, $allowed_ext)) {
        // Jika valid, pindahkan file ke folder upload
        move_uploaded_file($file_tmp, '../upload/'.$file_name);
    } else {
        // Jika ekstensi tidak valid, redirect ke halaman error
        header('Location: add_event.php?error=1');
        exit();  // Menghentikan eksekusi kode lebih lanjut
    }

    // Query untuk memasukkan data ke database
    $sql = "INSERT INTO event_konser(nama_event,tanggal,waktu,lokasi,deskripsi,jumlah_max_partisipan, banner_event, status_event) VALUES (?,?,?,?,?,?,?,?)";
    $stmt = $db->prepare($sql);
    $data = [$nama_event, $tanggal, $waktu, $lokasi, $deskripsi, $jumlah_max_partisipan, $file_name, 1];
    $stmt->execute($data);

    // Redirect ke halaman admin setelah sukses
    header('Location: ../admin/index.php');
?>