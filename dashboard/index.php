<?php
session_start();
require_once '../db.php'; // Adjust the path if necessary

// Fetch all events from the event_konser table
$sql = "SELECT id_event, nama_event, tanggal, waktu, lokasi, deskripsi, jumlah_partisipan, jumlah_max_partisipan, banner_event, status_event FROM event_konser WHERE status_event = 'open'";
$result = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Event Konser</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
        }
        img {
            width: 20%;
        }
    </style>
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
<body class="bg-gray-100">
    <div class="container mx-auto mt-10 p-5 bg-white rounded shadow">
        <h1 class="text-center text-3xl font-bold mb-5">Daftar Event Konser</h1>

        <!-- Profile link -->
        <div class="text-right mb-4">
            <a href="profile.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">My Profile</a>
        </div>

        <!-- Display success or error message -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="mb-4 text-green-600 bg-green-100 p-3 rounded">
                <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="mb-4 text-red-600 bg-red-100 p-3 rounded">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <?php if ($result->rowCount() > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <?php while($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="flex border border-gray-300 rounded-lg overflow-hidden shadow">
                    <div class="w-1/3">
                        <?php if ($row['banner_event']): ?>
                            <img src="../upload/<?= htmlspecialchars($row['banner_event']) ?>" alt="Banner" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">No banner</div>
                        <?php endif; ?>
                    </div>
                    <div class="w-2/3 p-4 flex flex-col justify-between">
                        <div>
                            <h2 class="text-xl font-bold"><?= htmlspecialchars($row['nama_event']) ?></h2>
                            <p><strong>Tanggal:</strong> <?= htmlspecialchars($row['tanggal']) ?></p>
                            <p><strong>Waktu:</strong> <?= htmlspecialchars($row['waktu']) ?></p>
                            <p><strong>Lokasi:</strong> <?= htmlspecialchars($row['lokasi']) ?></p>
                            <p><strong>Deskripsi:</strong> <?= htmlspecialchars($row['deskripsi']) ?></p>
                            <p><strong>Partisipan:</strong> <?= htmlspecialchars($row['jumlah_partisipan']) . "/" . htmlspecialchars($row['jumlah_max_partisipan']) ?></p>
                        </div>
                        <div class="mt-4">
                            <a href="regis.php?id_event=<?= htmlspecialchars($row['id_event']) ?>" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">Register</a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="text-center mt-5">
                <p class="text-gray-600">Tidak ada event konser yang terbuka saat ini.</p>
            </div>
        <?php endif; ?>

        <!-- Logout link -->
        <div class="mt-4 text-left">
            <a href="../logout.php" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">Logout</a>
        </div>
    </div>
</body>
</html>
