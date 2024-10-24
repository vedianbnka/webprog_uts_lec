<?php
session_start();
require_once '../db.php';

$id_user = $_GET['id_user'];
$sql = "SELECT * FROM user WHERE id_user = ?";
$statement = $db->prepare($sql);
$statement->execute([$id_user]);
$user = $statement->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Konserhub</title>
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.5/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../brand/icon.png" type="image/x-icon">
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
        }
        img {
            width: 100%;
        }
    </style>
    <script>
        function checkSession() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "../check_session_admin.php", true);
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

        setInterval(checkSession, 1000);

        function toggleMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>

<style>

@media (min-width: 1024px) {
    #mobile-menu {
        display: flex; /* Show the menu on larger screens */
    }
}
</style>
</head>
<body class="bg-gray-100">
    <div>
        <!-- Header with Logo and Navigation Button -->
        <header class="bg-[#7B61FF] text-white flex justify-between items-center p-4">
            <div class="flex items-center space-x-4">
                <!-- Logo -->
                <img src="../brand/logo_white.png" alt="Website Logo" class="h-12 w-auto">
            </div>
            <!-- Hamburger Menu Button for Mobile -->
            <button id="navigasi" class="bg-[#7B61FF] text-white p-2 rounded-md focus:outline-none lg:hidden" onclick="toggleMenu()">☰</button>
        </header>

        <!-- Navigation Bar (Moves from left to top) -->
        <nav class="bg-[#7B61FF] hidden lg:flex lg:flex-row items-center justify-center w-full py-4" id="mobile-menu">
            <ul class="flex flex-col lg:flex-row space-y-4 lg:space-y-0 lg:space-x-8">
                <li><a href="index.php" class="text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Dashboard</a></li>
                <li><a href="add_event.php" class="text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Add Events</a></li>
                <li><a href="view_user.php" class="text-white py-2 px-4 rounded hover:bg-[#6A52E0]">User Management</a></li>
                <li><a href="list_admin.php" class="text-white py-2 px-4 rounded hover:bg-[#6A52E0]">List Admin</a></li>
                <li><a href="../logout.php" class="text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Logout</a></li>
            </ul>
        </nav>

        <main class="flex-1 p-4">
        <!-- Header -->
        <header class="bg-white shadow p-4 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-black">history</h2>
            <div class="text-gray-700">Welcome, <?php echo $_SESSION['nama']; ?></div>
        </header>

            <!-- Content -->
            <main class="p-6 bg-gray-100">
                <!-- History Section -->
                <section class="bg-white p-6 rounded-lg shadow-lg mb-8">
                    <h3 class="text-xl font-semibold text-black mb-4">List History Partisipan <?php echo $user['nama']; ?></h3>
                    <button class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                        <a href="excel_history.php?id_user=<?= $id_user ?>" class="text-white-700 hover:underline">Download Excel</a>
                    </button>
                    <div class="table-responsive mt-4 overflow-x-auto">
    <table id="tabell" class="display w-full min-w-[600px] bg-white shadow-lg rounded-lg overflow-hidden">
        <thead class="bg-[#7B61FF] text-white">
            <tr class="divide-y divide-transparent">
                <th class="py-3 px-4 text-left">Nama Event</th>
                <th class="py-3 px-4 text-left">Tanggal Register</th>
                <th class="py-3 px-4 text-left">Tipe Tiket</th>
                <th class="py-3 px-4 text-left">Jumlah Pembelian Tiket</th>
                <th class="py-3 px-4 text-left">No. tiket</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-transparent"> <!-- Add this class to remove borders -->
            <?php
                $sql = "SELECT * FROM list_partisipan_event AS p JOIN event_konser AS e ON p.id_event = e.id_event WHERE p.id_user = ? AND p.status = 'approved'";
                $statement = $db->prepare($sql);
                $statement->execute([$id_user]);
                while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <tr class="hover:bg-gray-100 transition-colors divide-y divide-transparent">
                <td class="py-2 px-4"><?= $row['nama_event'] ?></td>
                <td class="py-2 px-4"><?= $row['tanggal_register'] ?></td>
                <td class="py-2 px-4"><?= $row['tipe_tiket'] ?></td>
                <td class="py-2 px-4"><?= $row['jumlah'] ?></td>
                <td class="py-2 px-4"><?= $row['no_tiket'] ?></td>
            </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</div>




                </section>          
            </main>
        </div>
    </div>
    <footer class="bg-gray-900 bg-opacity-80 text-white py-8">
    <div class="container mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 px-4 md:px-8">
        <!-- About Company Section -->
        <div class="flex flex-col">
            <h4 class="font-semibold text-lg mb-4">About Company</h4>
            <p class="text-sm">2-c-20, Kansua, Kota Rajasthan-324004</p>
            <div class="flex space-x-4 mt-4">
                <!-- Social Media Icons -->
                <a href="#"><img src="../brand/ig2.png" alt="Instagram" class="w-6 h-6"></a>
                <a href="#"><img src="../brand/tiktokWhite.png" alt="TikTok" class="w-6 h-6"></a>
                <a href="#"><img src="../brand/x.png" alt="WhatsApp" class="w-6 h-6"></a>
            </div>
        </div>

        <!-- Service Section -->
        <div class="flex flex-col">
            <h4 class="font-semibold text-lg mb-4">Service</h4>
            <ul class="text-sm space-y-2">
                <li><a href="add_event.php" class="hover:text-blue-300">Add Event</a></li>
                <li><a href="list_peserta.php" class="hover:text-blue-300">User Management</a></li>
                <li><a href="add_admin.php" class="hover:text-blue-300">Add Admin</a></li>
            </ul>
        </div>

        <!-- Useful Links Section -->
        <div class="flex flex-col">
            <h4 class="font-semibold text-lg mb-4">Useful Links</h4>
            <ul class="text-sm space-y-2">
                <li><a href="#" class="hover:text-blue-300">About Us</a></li>
                <li><a href="#" class="hover:text-blue-300">Team</a></li>
                <li><a href="#" class="hover:text-blue-300">Portfolio</a></li>
                <li><a href="#" class="hover:text-blue-300">Services</a></li>
                <li><a href="#" class="hover:text-blue-300">Contact Us</a></li>
            </ul>
        </div>

        <!-- Contact Us Section -->
        <div class="flex flex-col">
            <h4 class="font-semibold text-lg mb-4">Contact Us</h4>
            <a class="hover:text-blue-300">+021-5993693  <br> +62-354168293</a>
        </div>
    </div>

    <div class="border-t border-gray-600 mt-8 pt-4 text-center">
        <p class="text-sm">&copy;2024 Konserhub. All rights reserved.</p>
    </div>
</footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.1.5/datatables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#tabell').DataTable(); 
        });
    </script>
</body>
</html>
