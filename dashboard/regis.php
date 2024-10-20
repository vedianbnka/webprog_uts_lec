<?php
session_start();
require_once '../db.php';

// Check if user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header('Location: ../login/index.php');
//     exit();
// }

if (!isset($_GET['id_event'])) {
    $_SESSION['error'] = 'No event selected.';
    header('Location: index.php');
    exit();
}

$id_event = $_GET['id_event'];

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

if ($event['status_event'] != 'open' || $jumlah_sold >= $kuota) {
    $_SESSION['error'] = 'Event is full or closed for registration.';
    header('Location: index.php');
    exit();
}

$sql = "SELECT tipe_tiket, harga, jumlah_sold, kuota FROM tiket WHERE id_event = :id_event";
$stmt = $db->prepare($sql);
$stmt->execute(['id_event' => $id_event]);
$tikets = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($tikets as &$tiket) {
    $tiket['sisa_kuota'] = $tiket['kuota'] - $tiket['jumlah_sold'];
}

// Encode data ke dalam JSON
$tiketsJson = json_encode($tikets);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register for Event: <?= htmlspecialchars($event['nama_event']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function checkSession() {
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
    <style>
        @keyframes slideSide {
            0% {
                transform: translateX(-100px);
                opacity: 0;
            }
            100% {
                transform: translateX(0px);
                opacity: 1;
            }
        }

        .animasi {
            animation: slideSide 1s;
        }
    </style>
</head>
<body class="relative min-h-screen flex items-center justify-center">

    <form action="regis_proses.php" method="POST" class="p-6 bg-opacity-100 border rounded-lg bg-white shadow-lg animasi max-w-xs w-full" enctype="multipart/form-data">
        <h2 class="text-2xl font-bold text-center mb-4 text-[#7B61FF]">Register for Event: <?= htmlspecialchars($event['nama_event']) ?></h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-500 text-white p-2 rounded mb-3">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
    
        <input type="hidden" name="id_event" value="<?= $id_event ?>">

        <div class="mb-3">
            <label for="email" class="block mb-1 text-gray-700 text-sm">Email</label>
            <input type="email" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-[#7B61FF]" id="email" name="email" value="<?= $_SESSION['email']; ?>" disabled>
        </div>

        <div class="mb-3">
            <label for="nama" class="block mb-1 text-gray-700 text-sm">Nama Lengkap</label>
            <input type="text" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-[#7B61FF]" id="nama" name="nama" value="<?= $_SESSION['nama']; ?>" disabled>
        </div>

        <div class="mb-3">
            <label for="tipe_tiket" class="block mb-1 text-gray-700 text-sm">Tipe Tiket</label>
            <select class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-[#7B61FF]" name="tipe_tiket" id="tipe_tiket" onchange="updateKuotaAndTotal()">
                <option value="" disabled selected>Pilih Tipe Tiket</option>
                <?php foreach ($tikets as &$tiket): ?>
                    <option value="<?= $tiket['tipe_tiket'] ?>" data-harga="<?= $tiket['harga'] ?>" data-sisa-kuota="<?= $tiket['sisa_kuota'] ?>">
                        <?= $tiket['tipe_tiket'] ?> - Rp. <?= number_format($tiket['harga'], 0, ',', '.') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="jumlah_tiket" class="block mb-1 text-gray-700 text-sm">Jumlah Tiket (Maks. <span id="max_kuota">0</span>)</label>
            <input type="number" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-[#7B61FF]" id="jumlah_tiket" name="jumlah_tiket" min="1" max="0" required oninput="updateTotal()">
        </div>

        <div class="mb-3">
            <label for="total_harga" class="block mb-1 text-gray-700 text-sm">Total Harga</label>
            <input type="text" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-[#7B61FF]" id="total_harga" name="total_harga" disabled>
        </div>

        <div class="mb-3">
            <label for="bukti_pembayaran" class="block mb-1 text-gray-700 text-sm">Bukti Pembayaran</label>
            <input type="file" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-[#7B61FF]" id="bukti_pembayaran" name="bukti_pembayaran">
        </div>

        <div class="flex justify-between mt-4">
            <a href="index.php" class="bg-green-500 text-white px-4 py-1 rounded hover:bg-green-600 text-sm">Back</a>
            <button type="submit" class="bg-[#7B61FF] text-white px-4 py-1 rounded hover:bg-[#6A52E0] text-sm">Book</button>
        </div>
    </form>

<script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.js"></script>
<script>
    function updateKuotaAndTotal() {
        var tipeTiketSelect = document.getElementById('tipe_tiket');
        var selectedOption = tipeTiketSelect.options[tipeTiketSelect.selectedIndex];

        // Ambil sisa kuota dan harga dari data attribute
        var sisaKuota = selectedOption.getAttribute('data-sisa-kuota');
        var harga = selectedOption.getAttribute('data-harga');

        // Update max kuota untuk jumlah tiket
        document.getElementById('max_kuota').innerText = sisaKuota;
        document.getElementById('jumlah_tiket').max = sisaKuota;

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

        document.getElementById('total_harga').value = new Intl.NumberFormat('id-ID').format(totalHarga);
    }
</script>
</body>
</html>
