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
    $id_event = $_GET['id_event'];

    $sqll = "SELECT * FROM event_konser WHERE id_event = ?";
    $stmtt = $db->prepare($sqll);
    $stmtt->execute([$id_event]);
    $event = $stmtt->fetch();

    $gambar_sebelum = $event['banner_event'];
    $file_path = "../upload/" . $gambar_sebelum;
    

// Cek apakah file tersebut ada
if (file_exists($file_path)) {
    // Jika file ada, hapus file
    if (unlink($file_path)) {
        echo "File berhasil dihapus.";
    } else {
        echo "Gagal menghapus file.";
    }
} else {
    echo "File tidak ditemukan.";
}

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
        header('Location: edit_event.php?error=1');
        exit();  // Menghentikan eksekusi kode lebih lanjut
    }

    // Query untuk memasukkan data ke database
    $sql = "UPDATE event_konser SET nama_event = ?, tanggal = ?, waktu = ?, lokasi = ?, deskripsi = ?, jumlah_max_partisipan = ?, banner_event = ? WHERE id_event = ?";
    $stmt = $db->prepare($sql);
    $data = [$nama_event, $tanggal, $waktu, $lokasi, $deskripsi, $jumlah_max_partisipan, $file_name, $id_event];
    $stmt->execute($data);

    // Redirect ke halaman admin setelah sukses
    header('Location: ../admin/index.php');
?>