<?php
session_start();
require_once '../db.php'; // Adjust the path if necessary

// // Check if user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header('Location: ../login/index.php');
//     exit();
// }

// Check if event ID is provided
if (!isset($_GET['id_event'])) {
    $_SESSION['error'] = 'No event selected.';
    header('Location: index.php');
    exit();
}

$id_event = $_GET['id_event'];

// Fetch event details
$sql = "SELECT * FROM event_konser WHERE id_event = :id_event";
$stmt = $db->prepare($sql);
$stmt->execute(['id_event' => $id_event]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

$sqll = "SELECT * FROM tiket WHERE id_event = $_GET[id_event]";
                        $result = $db->query($sqll);
                        $kuota = 0;
                        $jumlah_sold = 0;
                        while ($roww = $result->fetch(PDO::FETCH_ASSOC)) {
                            $jumlah_sold += $roww['jumlah_sold'];
                            $kuota += $roww['kuota'];
                        }

if (!$event) {
    $_SESSION['error'] = 'Event not found.';
    header('Location: index.php');
    exit();
}

// Display form only if event is open and has available slots
if ($event['status_event'] != 'open' || $jumlah_sold >= $kuota) {
    $_SESSION['error'] = 'Event is full or closed for registration.';
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register for Event: <?= htmlspecialchars($event['nama_event']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function checkSession() {
  // Kirim permintaan AJAX ke check_session.php
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../check_session.php", true);
    xhr.onload = function () {
    if (xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.status === "inactive") {
        window.location.href = "../login/index.php";
    }
    }
    };
    xhr.send();
}

setInterval(checkSession, 1);
    </script>
</head>
<body>
<div class="container mt-5">
    <h1>Register for Event: <?= htmlspecialchars($event['nama_event']) ?></h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form action="regis_proses.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_event" value="<?= $id_event ?>">

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= $_SESSION['email']; ?>" disabled>
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?= $_SESSION['nama']; ?>" disabled>
        </div>

        <div class="mb-3">
            <label for="tipe_tiket" class="form-label">Tipe Tiket</label><br>
            <select class="status-dropdown" name="tipe_tiket"> 
                            <option value="vvip">VVIP</option>
                            <option value="vip">VIP</option>
                            <option value="cat1">CAT 1</option>
                            <option value="cat2">CAT 2</option>
                            <option value="cat3">CAT 3</option>
                        </select>
        </div>

        <div class="mb-3 form-group">
            <label for="jumlah_tiket" class="form-label">Jumlah Tiket (max. 10)</label>
            <input type="number" class="form-control" id="jumlah_tiket" name="jumlah_tiket" min="1" max="10" required>
        </div>

        <div class="mb-3">
    <label for="total_harga" class="form-label">Total Harga</label>
    <input type="text" class="form-control" id="total_harga" name="total_harga" readonly>
</div>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tipeTiketSelect = document.getElementById('tipe_tiket');
        const jumlahTiketInput = document.getElementById('jumlah_tiket');
        const totalHargaInput = document.getElementById('total_harga');
        let hargaPerTiket = 0;

        // Fungsi untuk mengambil harga dari server
        function getHargaTiket(tipeTiket) {
            if (tipeTiket !== "") {
                // Menggunakan AJAX untuk mendapatkan harga dari server
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "get_price.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        hargaPerTiket = parseInt(response.harga);
                        hitungTotal();
                    }
                };
                xhr.send("tipe_tiket=" + tipeTiket);
            }
        }

        // Fungsi untuk menghitung total harga
        function hitungTotal() {
            const jumlahTiket = parseInt(jumlahTiketInput.value) || 0;
            const totalHarga = hargaPerTiket * jumlahTiket;
            totalHargaInput.value = totalHarga.toLocaleString('id-ID') + ' IDR';
        }

        // Event listener untuk mengambil harga saat tipe tiket berubah
        tipeTiketSelect.addEventListener('change', function() {
            const tipeTiket = tipeTiketSelect.value;
            getHargaTiket(tipeTiket);
        });

        // Event listener untuk menghitung total harga saat jumlah tiket berubah
        jumlahTiketInput.addEventListener('input', hitungTotal);
    });
</script>
</body>
</html>
