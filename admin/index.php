<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Konserhub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.5/datatables.min.css" rel="stylesheet">
    <link rel="icon" href="icon.png" type="image/x-icon">
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
        setInterval(checkSession, 1);
    </script>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <aside class="w-64 bg-[#7B61FF] h-screen p-4">
        <img src="../brand/logo_white.png" alt="Website Logo" class="img-fluid">
            <nav>
                <ul class="space-y-4">
                    <li><a href="index.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Dashboard</a></li>
                    <li><a href="add_event.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Add Events</a></li>
                    <li><a href="view_user.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">User Management</a></li>
                    <li><a href="add_admin.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Add Admin</a></li>
                    <li><a href="#" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Settings</a></li>
                    <li><a href="../logout.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Logout</a></li>
                </ul>
            </nav>
        </aside>
        <div class="flex-1">
            <header class="bg-white shadow p-4 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-black">Dashboard</h2>
                <h3>Selamat Datang, <?php echo isset($_SESSION['admin_name']) ? htmlspecialchars($_SESSION['admin_name']) : 'Admin'; ?></h3>
            </header>
            <main class="p-6 bg-gray-100">
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
                <section class="bg-white p-6 rounded-lg shadow-lg mb-8">
                    <h3 class="text-xl font-semibold text-black mb-4">Manage Events</h3>
                    <div class="table-responsive">
                        <table id="tabell" class="min-w-full bg-white">
                            <thead class="bg-[#7B61FF] text-white">
                                <tr>
                                    <th class="py-3 px-4 text-left">Nama Event</th>
                                    <th class="py-3 px-4 text-left">Foto</th>
                                    <th class="py-3 px-4 text-left">Status Event</th>
                                    <th class="py-3 px-4 text-left">Partisipan</th>
                                    <th class="py-3 px-4 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                <?php
                                    require_once "../db.php";
                                    $sql = "SELECT * FROM event_konser";
                                    $hasil = $db->query($sql);

                                    while ($row = $hasil->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <tr>
                                        <td class="py-2 px-4"><?= $row['nama_event'] ?></td>
                                        <td class="py-2 px-4"><img class="h-16 w-32 object-cover" src="../upload/<?= $row['banner_event'] ?>" alt=""></td>
                                        <td class="py-2 px-4">
                                            <form method="post" action="update_status.php?id_event=<?= $row['id_event'] ?>">
                                                <select class="bg-gray-200 border border-gray-300 p-2 rounded" name="status" onchange="this.form.submit()">
                                                    <option value="open" <?= $row['status_event'] == 'open' ? 'selected' : '' ?>>Active</option>
                                                    <option value="closed" <?= $row['status_event'] == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                    <option value="canceled" <?= $row['status_event'] == 'canceled' ? 'selected' : '' ?>>Canceled</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="py-2 px-4">
                                            <?php
                                            $sqll = "SELECT * FROM tiket WHERE id_event = $row[id_event]";
                                            $result = $db->query($sqll);
                                            $kuota = 0;
                                            $jumlah_sold = 0;
                                            while ($roww = $result->fetch(PDO::FETCH_ASSOC)) {
                                                $jumlah_sold += $roww['jumlah_sold'];
                                                $kuota += $roww['kuota'];
                                            }
                                            echo $jumlah_sold . " / " . $kuota;
                                            ?>
                                        </td>
                                        <td class="py-2 px-4">
                                            <div class="flex gap-2">
                                                <a href="edit_event.php?id_event=<?= $row['id_event'] ?>" class="text-[#7B61FF] hover:underline">Edit</a>
                                                <a href="detail_event.php?id_event=<?= $row['id_event'] ?>" class="text-[#7B61FF] hover:underline">Detail Event</a>
                                                <a href="list_peserta.php?id_event=<?= $row['id_event'] ?>" class="text-[#7B61FF] hover:underline">List Peserta</a>
                                                <a href="delete_event.php?id_event=<?= $row['id_event'] ?>" class="text-red-500 hover:underline">Delete</a>
                                            </div>
                                        </td>
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
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- About Company Section -->
            <div>
                <h4 class="font-semibold text-lg mb-4">About Company</h4>
                <p class="text-sm">2-c-20, Kansua, Kota Rajasthan-324004</p>
                <div class="flex space-x-4 mt-4">
                    <!-- Social Media Icons -->
                    <a href="#"><img src="../brand/ig2.png" alt="Facebook" class="w-6 h-6"></a>
                    <a href="#"><img src="../brand/tiktokWhite.png" alt="YouTube" class="w-6 h-6"></a>
                    <a href="#"><img src="../brand/x.png" alt="WhatsApp" class="w-6 h-6"></a>
                </div>
            </div>

            <!-- Service Section -->
            <div>
                <h4 class="font-semibold text-lg mb-4">Service</h4>
                <ul class="text-sm space-y-2">
                    <li><a href="add-event.php" class="hover:text-blue-300">Add Event</a></li>
                    <li><a href="view_user.php" class="hover:text-blue-300">User Management</a></li>
                    <li><a href="add_admin.php" class="hover:text-blue-300">Add Admin</a></li>
                </ul>
            </div>

            <!-- Useful Links Section -->
            <div>
                <h4 class="font-semibold text-lg mb-4">Useful Link</h4>
                <ul class="text-sm space-y-2">
                    <li><a href="#" class="hover:text-blue-300">About Us</a></li>
                    <li><a href="#" class="hover:text-blue-300">Team</a></li>
                    <li><a href="#" class="hover:text-blue-300">Portfolio</a></li>
                    <li><a href="#" class="hover:text-blue-300">Services</a></li>
                    <li><a href="#" class="hover:text-blue-300">Contact Us</a></li>
                </ul>
            </div>

            <!-- Contact Us Section -->
            <div>
                <h4 class="font-semibold text-lg mb-4">Contact Us</h4>
                <form class="flex flex-col space-y-4">
                    <input type="email" placeholder="My Email" class="px-4 py-2 rounded-md text-gray-700 focus:outline-none">
                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded-md">Submit</button>
                </form>
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
