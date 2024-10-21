<?php
session_start();
require_once '../db.php';

$id_event = $_GET['id_event'];
$sql = "SELECT * FROM event_konser WHERE id_event = ?";
$statement = $db->prepare($sql);
$statement->execute([$id_event]);
$event = $statement->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Konserhub</title>
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.5/datatables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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

        setInterval(checkSession, 1000); // Changed to 1000ms for a more reasonable interval
    </script>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <aside class="w-64 bg-[#7B61FF] h-screen p-4">
            <h2 class="text-2xl font-bold text-white mb-6">Konserhub Admin</h2>
            <nav>
                <ul class="space-y-4">
                    <li>
                        <a href="index.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Dashboard</a>
                    </li>
                    <li>
                        <a href="add_event.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Add Events</a>
                    </li>
                    <li>
                        <a href="list_peserta.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Participants</a>
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
                <h2 class="text-2xl font-bold text-black">Dashboard</h2>
                <div class="text-gray-700">Welcome, Admin</div>
            </header>

            <!-- Content -->
            <main class="p-6 bg-gray-100">
                <!-- Manage Participants Section -->
                <section class="bg-white p-6 rounded-lg shadow-lg mb-8">
                    <h3 class="text-xl font-semibold text-black mb-4">List Partisipan <?php echo $event['nama_event']; ?></h3>
                    <button class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                        <a href="download_excel.php?id_event=<?= $id_event ?>" class="text-white-700 hover:underline">Download Excel</a>
                    </button>
                    <div class="table-responsive mt-4">
                        <table id="tabell" class="display w-100">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Tanggal Register</th>
                                    <th>Tipe Tiket</th>
                                    <th>Jumlah Pembelian Tiket</th>
                                    <th>Bukti Pembayaran</th>
                                    <th>Action</th>
                                    <th>No. tiket</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT u.nama, p.tanggal_register, p.tipe_tiket, p.jumlah, p.bukti_pembayaran, p.status, p.id_partisipan, p.no_tiket FROM list_partisipan_event AS p JOIN user AS u ON p.id_user=u.id_user WHERE p.id_event = ?";
                                    $statement = $db->prepare($sql);
                                    $statement->execute([$id_event]);
                                    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <tr>
                                    <td><?= $row['nama'] ?></td>
                                    <td><?= $row['tanggal_register'] ?></td>
                                    <td><?= $row['tipe_tiket'] ?></td>
                                    <td><?= $row['jumlah'] ?></td>
                                    <td><img class="img-fluid" src="../bukti_pembayaran/<?= $row['bukti_pembayaran'] ?>" alt=""></td>
                                    <td>
                                        <form method="post" action="status_tiket.php?id_event=<?= $id_event ?>&id_partisipan=<?= $row['id_partisipan'] ?>">
                                            <select class="status-dropdown" name="status" onchange="this.form.submit()"> 
                                                <option value="approved" <?= $row['status'] == 'approved' ? 'selected' : '' ?>>Approved</option>
                                                <option value="pending" <?= $row['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                                <option value="rejected" <?= $row['status'] == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td><?= $row['no_tiket'] == null ? '-' : $row['no_tiket'] ?></td>
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
