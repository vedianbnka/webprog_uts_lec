<?php
    require_once "../db.php";

    // Mengambil data dari form
    $nama_event = $_POST['nama_event'];
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];
    $lokasi = $_POST['lokasi'];
    $deskripsi = $_POST['deskripsi'];
    $file_name = $_FILES['banner_event']['name'];
    $file_tmp = $_FILES['banner_event']['tmp_name'];
    $tipe_tiket = $_POST['tipe_tiket'];

    

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
    $sql = "INSERT INTO event_konser(nama_event,tanggal,waktu,lokasi,deskripsi, banner_event, status_event) VALUES (?,?,?,?,?,?,?)";
    $stmt = $db->prepare($sql);
    $data = [$nama_event, $tanggal, $waktu, $lokasi, $deskripsi, $file_name, 1];
    $stmt->execute($data);

    $sql = "SELECT id_event FROM event_konser WHERE nama_event = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$nama_event]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $id_event = $result['id_event'];

    for ($i = 0; $i < count($tipe_tiket); $i++) {
        if ($tipe_tiket[$i] == 'vvip') {
            $vvip_harga = $_POST['vvip_harga'];
            $vvip_kuota = $_POST['vvip_kuota'];
            $vvip_benefit = $_POST['vvip_benefit'];

            $sql = "INSERT INTO tiket(id_event, tipe_tiket,kuota, harga, benefit) VALUES (?,?,?,?,?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id_event, $tipe_tiket[$i], $vvip_kuota, $vvip_harga, $vvip_benefit]);
        } 
        if ($tipe_tiket[$i] == 'vip') {
            $vip_harga = $_POST['vip_harga'];
            $vip_kuota = $_POST['vip_kuota'];
            $vip_benefit = $_POST['vip_benefit'];
            $sql = "INSERT INTO tiket(id_event, tipe_tiket,kuota, harga, benefit) VALUES (?,?,?,?,?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id_event, $tipe_tiket[$i], $vip_kuota, $vip_harga, $vip_benefit]);
        } 
        if ($tipe_tiket[$i] == 'cat1') {
            $cat1_harga = $_POST['cat1_harga'];
            $cat1_kuota = $_POST['cat1_kuota'];
            $cat1_benefit = $_POST['cat1_benefit'];
            $sql = "INSERT INTO tiket(id_event, tipe_tiket,kuota, harga, benefit) VALUES (?,?,?,?,?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id_event, $tipe_tiket[$i], $cat1_kuota, $cat1_harga, $cat1_benefit]);
        }
        if ($tipe_tiket[$i] == 'cat2') {
            $cat2_harga = $_POST['cat2_harga'];
            $cat2_kuota = $_POST['cat2_kuota'];
            $cat2_benefit = $_POST['cat2_benefit'];
            $sql = "INSERT INTO tiket(id_event, tipe_tiket,kuota, harga, benefit) VALUES (?,?,?,?,?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id_event, $tipe_tiket[$i], $cat2_kuota, $cat2_harga, $cat2_benefit]);
        }
        if ($tipe_tiket[$i] == 'cat3') {
            $cat3_harga = $_POST['cat3_harga'];
            $cat3_kuota = $_POST['cat3_kuota'];
            $cat3_benefit = $_POST['cat3_benefit'];

            $sql = "INSERT INTO tiket(id_event, tipe_tiket,kuota, harga, benefit) VALUES (?,?,?,?,?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id_event, $tipe_tiket[$i], $cat3_kuota, $cat3_harga, $cat3_benefit]);
        }
    }

    // Redirect ke halaman admin setelah sukses
    header('Location: ../admin/index.php');
?>