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

$sql = "SELECT tipe_tiket, harga, kuota FROM tiket WHERE id_event = :id_event";
$stmt = $db->prepare($sql);
$stmt->execute(['id_event' => $id_event]);
$tikets = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Encode data ke dalam JSON
$tiketsJson = json_encode($tikets);
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
            <select class="status-dropdown" name="tipe_tiket" id="tipe_tiket" onchange="updateKuotaAndTotal()"> 
                <option value="" disabled selected>Pilih Tipe Tiket</option>
                <?php foreach ($tikets as $tiket): ?>
                    <option value="<?= $tiket['tipe_tiket'] ?>" data-harga="<?= $tiket['harga'] ?>" data-kuota="<?= $tiket['kuota'] ?>">
                        <?= $tiket['tipe_tiket'] ?> - Rp. <?= number_format($tiket['harga'], 0, ',', '.') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3 form-group">
            <label for="jumlah_tiket" class="form-label">Jumlah Tiket (Maks. <span id="max_kuota">0</span>)</label>
            <input type="number" class="form-control" id="jumlah_tiket" name="jumlah_tiket" min="1" max="0" required oninput="updateTotal()">
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
    // Ambil data tiket dari PHP (encoded JSON)
    var tiketData = <?= $tiketsJson ?>;

    function updateKuotaAndTotal() {
        var tipeTiketSelect = document.getElementById('tipe_tiket');
        var selectedOption = tipeTiketSelect.options[tipeTiketSelect.selectedIndex];

        // Ambil kuota dan harga dari data attribute
        var kuota = selectedOption.getAttribute('data-kuota');
        var harga = selectedOption.getAttribute('data-harga');

        // Update max kuota untuk jumlah tiket
        document.getElementById('max_kuota').innerText = kuota;
        document.getElementById('jumlah_tiket').max = kuota;

        // Reset total harga
        document.getElementById('total_harga').value = "0";
    }

    function updateTotal() {
        var jumlahTiket = document.getElementById('jumlah_tiket').value;
        var tipeTiketSelect = document.getElementById('tipe_tiket');
        var selectedOption = tipeTiketSelect.options[tipeTiketSelect.selectedIndex];
        var harga = selectedOption.getAttribute('data-harga');

        // Hitung total harga
        var totalHarga = jumlahTiket * harga;

        // Format total harga dan update di input total_harga
        document.getElementById('total_harga').value = new Intl.NumberFormat('id-ID').format(totalHarga);
    }
</script>


</body>
</html>
