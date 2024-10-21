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
    </script>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <aside class="w-64 bg-[#7B61FF] h-screen p-4">
        <img src="../brand/logo_white.png" alt="Website Logo" class="img-fluid">
            <nav>
                <ul class="space-y-4">
                    <li>
                        <a href="index.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Dashboard</a>
                    </li>
                    <li>
                        <a href="add_event.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Add Events</a>
                    </li>
                    <li>
                        <a href="view_user.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">User Management</a>
                    </li>
                    <li><a href="../admin/add_admin.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Add Admin</a></li>
                    <li>
                        <a href="#" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Settings</a>
                    </li>
                    <li>
                        <a href="#" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Logout</a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
            <header class="bg-white shadow p-4 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-black">Participant History</h2>
                <div class="text-gray-700">Welcome, Admin</div>
            </header>

            <!-- Content -->
            <main class="p-6 bg-gray-100">
                <!-- History Section -->
                <section class="bg-white p-6 rounded-lg shadow-lg mb-8">
                    <h3 class="text-xl font-semibold text-black mb-4">List History Partisipan <?php echo $user['nama']; ?></h3>
                    <button class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                        <a href="excel_history.php?id_user=<?= $id_user ?>" class="text-white-700 hover:underline">Download Excel</a>
                    </button>
                    <div class="table-responsive mt-4">
                        <table id="tabell" class="display w-100">
                            <thead>
                                <tr>
                                    <th>Nama Event</th>
                                    <th>Tanggal Register</th>
                                    <th>Tipe Tiket</th>
                                    <th>Jumlah Pembelian Tiket</th>
                                    <th>No. tiket</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM list_partisipan_event AS p JOIN event_konser AS e ON p.id_event = e.id_event WHERE p.id_user = ? AND p.status = 'approved'";
                                    $statement = $db->prepare($sql);
                                    $statement->execute([$id_user]);
                                    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <tr>
                                    <td><?= $row['nama_event'] ?></td>
                                    <td><?= $row['tanggal_register'] ?></td>
                                    <td><?= $row['tipe_tiket'] ?></td>
                                    <td><?= $row['jumlah'] ?></td>
                                    <td><?= $row['no_tiket'] ?></td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>          
            </main>

            <footer class="bg-black py-4 mt-8">
                <div class="text-center text-white">
                    © 2024 Konserhub Admin. All rights reserved.
                </div>
            </footer>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.1.5/datatables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#tabell').DataTable(); 
        });
    </script>
</body>
</html>
