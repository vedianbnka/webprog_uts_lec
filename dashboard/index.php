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
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-2 text-left">Nama Event</th>
                            <th class="px-4 py-2 text-left">Tanggal</th>
                            <th class="px-4 py-2 text-left">Waktu</th>
                            <th class="px-4 py-2 text-left">Lokasi</th>
                            <th class="px-4 py-2 text-left">Deskripsi</th>
                            <th class="px-4 py-2 text-left">Partisipan</th>
                            <th class="px-4 py-2 text-left">Banner</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php while($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td class="px-4 py-2"><?= htmlspecialchars($row['nama_event']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($row['tanggal']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($row['waktu']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($row['lokasi']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($row['deskripsi']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($row['jumlah_partisipan']) . "/" . htmlspecialchars($row['jumlah_max_partisipan']) ?></td>
                            <td class="px-4 py-2">
                                <?php if ($row['banner_event']): ?>
                                    <img src="../upload/<?= htmlspecialchars($row['banner_event']) ?>" alt="Banner" class="w-24 h-16 object-cover">
                                <?php else: ?>
                                    No banner
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-2"><?= ucfirst(htmlspecialchars($row['status_event'])) ?></td>
                            <td class="px-4 py-2">
                                <a href="regis.php?id_event=<?= htmlspecialchars($row['id_event']) ?>" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">Register</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
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
