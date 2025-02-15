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
        <link
            href="https://cdn.datatables.net/v/dt/dt-2.1.5/datatables.min.css"
            rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="icon" href="../brand/icon.png" type="image/x-icon">
        <style>
            table,
            td,
            th {
                border: 1px solid black;
                border-collapse: collapse;
            }
            td,
            th {
                padding: 5px;
            }
            img {
                width: 20%;
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
                menu
                    .classList
                    .toggle('hidden');
            }
        </script>

        <style>

            @media (min-width: 1024px) {
                #mobile-menu {
                    display: flex;
                    /* Show the menu on larger screens */
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
                <button
                    id="navigasi"
                    class="bg-[#7B61FF] text-white p-2 rounded-md focus:outline-none lg:hidden"
                    onclick="toggleMenu()">☰</button>
            </header>

            <!-- Navigation Bar (Moves from left to top) -->
            <nav
                class="bg-[#7B61FF] hidden lg:flex lg:flex-row items-center justify-center w-full py-4"
                id="mobile-menu">
                <ul class="flex flex-col lg:flex-row space-y-4 lg:space-y-0 lg:space-x-8">
                    <li>
                        <a href="index.php" class="text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Dashboard</a>
                    </li>
                    <li>
                        <a href="add_event.php" class="text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Add Events</a>
                    </li>
                    <li>
                        <a href="view_user.php" class="text-white py-2 px-4 rounded hover:bg-[#6A52E0]">User Management</a>
                    </li>
                    <li>
                        <a
                            href="list_admin.php"
                            class="text-white py-2 px-4 rounded hover:bg-[#6A52E0]">List Admin</a>
                    </li>
                    <li>
                        <a href="../logout.php" class="text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Logout</a>
                    </li>
                </ul>
            </nav>

            <main class="flex-1 p-4">
                <!-- Content -->
                <section class="bg-white p-6 rounded-lg shadow-lg mb-8">
                    <div class="text-gray-700 flex justify-end">Welcome,
                        <?= $_SESSION['nama']; ?></div>
                    <h3 class="text-xl font-semibold text-black mb-4">List Partisipan
                        <?php echo $event['nama_event']; ?></h3>

                    <button
                        class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                        <a
                            href="download_excel.php?id_event=<?= $id_event ?>"
                            class="text-white-700 hover:underline">Download Excel</a>
                    </button>
                    <div class="overflow-x-auto mt-4">
                        <table id="tabell" class="min-w-full bg-white shadow-lg rounded-lg">
                            <thead class="bg-[#7B61FF] text-white">
                                <tr>
                                    <th class="px-4 py-2 text-left">Nama</th>
                                    <th class="px-4 py-2 text-left">Tanggal Register</th>
                                    <th class="px-4 py-2 text-left">Tipe Tiket</th>
                                    <th class="px-4 py-2 text-left">Jumlah Pembelian Tiket</th>
                                    <th class="px-4 py-2 text-left">Bukti Pembayaran</th>
                                    <th class="px-4 py-2 text-left">Action</th>
                                    <th class="px-4 py-2 text-left">No. tiket</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <?php
                        $sql = "SELECT u.nama, p.tanggal_register, p.tipe_tiket, p.jumlah, p.bukti_pembayaran, p.status, p.id_partisipan, p.no_tiket 
                                FROM list_partisipan_event AS p 
                                JOIN user AS u ON p.id_user=u.id_user 
                                WHERE p.id_event = ?";
                        $statement = $db->prepare($sql);
                        $statement->execute([$id_event]);
                        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                                <tr class="border-b">
                                    <td class="px-4 py-2"><?= $row['nama'] ?></td>
                                    <td class="px-4 py-2"><?= $row['tanggal_register'] ?></td>
                                    <td class="px-4 py-2"><?= $row['tipe_tiket'] ?></td>
                                    <td class="px-4 py-2"><?= $row['jumlah'] ?></td>
                                    <td class="px-4 py-2"><a href="../bukti_pembayaran/<?= $row['bukti_pembayaran'] ?>" target="_blank"><img
                                        class="w-20"
                                        src="../bukti_pembayaran/<?= $row['bukti_pembayaran'] ?>"
                                        alt=""></a>
                                    </td>
                                    <td class="px-4 py-2">
                                        <form
                                            method="post"
                                            action="status_tiket.php?id_event=<?= $id_event ?>&id_partisipan=<?= $row['id_partisipan'] ?>">
                                            <select class="p-1 border rounded" name="status" onchange="this.form.submit()">
                                                <option value="approved" <?= $row['status'] == 'approved' ? 'selected' : '' ?>>Approved</option>
                                                <option value="pending" <?= $row['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                                <option value="rejected" <?= $row['status'] == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                                <option value="canceled" <?= $row['status'] == 'canceled' ? 'selected' : '' ?>>Canceled By User</option>
                                                <option value="canceled_admin" <?= $row['status'] == 'event canceled' ? 'selected' : '' ?>>Event Canceled</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-4 py-2"><?= $row['no_tiket'] == null ? '-' : $row['no_tiket'] ?></td>
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

        <footer class="bg-gray-900 bg-opacity-80 text-white py-8">
            <div
                class="container mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 px-4 md:px-8">
                <!-- About Company Section -->
                <div class="flex flex-col">
                    <h4 class="font-semibold text-lg mb-4">Our Social Media</h4>
                    <div class="flex space-x-4">
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
                        <li>
                            <a href="add_event.php" class="hover:text-blue-300">Add Event</a>
                        </li>
                        <li>
                            <a href="list_peserta.php" class="hover:text-blue-300">User Management</a>
                        </li>
                        <li>
                            <a href="add_admin.php" class="hover:text-blue-300">Add Admin</a>
                        </li>
                    </ul>
                </div>

                <!-- Useful Links Section -->
                <div class="flex flex-col">
                    <h4 class="font-semibold text-lg mb-4">Our Address</h4>
                    <p>Jl. Raya Cimanggis No. 2, Cimanggis, Kec. Cimanggis, Kota Depok, Jawa Barat</p>
                </div>

                <!-- Contact Us Section -->
                <div class="flex flex-col">
                    <h4 class="font-semibold text-lg mb-4">Contact Us</h4>
                    <h5 class="font text-md mb-4">☎️ : +62 354168293</h5>
                    <h5 class="font text-md mb-4">📩 : admin@konserhub.com</h5>
                </div>
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