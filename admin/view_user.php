<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Konserhub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="icon.png" type="image/x-icon">
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.5/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        setInterval(checkSession, 1); // Changed interval to 1 second for practicality
    </script>
</head>
<body class="bg-gray-100">
<body class="bg-gray-100">
    <div class="flex flex-col lg:flex-row">
        <aside class="w-full lg:w-64 bg-[#7B61FF] h-auto lg:h-screen p-4">
            <img src="../brand/logo_white.png" alt="Website Logo" class="mb-4 w-32 mx-auto lg:mx-0">
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
                    <li>
                    <a href="list_admin.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">List Admin</a>
                    </li>
                    <li>
                        <a href="#" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Settings</a>
                    </li>
                    <li>
                        <a href="../logout.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Logout</a>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="flex-1 p-4">
        <!-- Header -->
        <header class="bg-white shadow p-4 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-black">User Management</h2>
            <div class="text-gray-700">Welcome, <?= $_SESSION['nama']; ?></div>
        </header>

            <!-- Content -->
            <main class="p-6 bg-gray-100">
                <!-- Manage Users Section -->
                <section class="bg-white p-6 rounded-lg shadow-lg mb-8">
                    <h3 class="text-xl font-semibold text-black mb-4">Manage Users</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-[#7B61FF] text-white">
                                <tr>
                                    <th class="py-3 px-6 text-left text-sm font-semibold uppercase tracking-wider border-b border-[#7B61FF]">ID User</th>
                                    <th class="py-3 px-6 text-left text-sm font-semibold uppercase tracking-wider border-b border-[#7B61FF]">Nama</th>
                                    <th class="py-3 px-6 text-left text-sm font-semibold uppercase tracking-wider border-b border-[#7B61FF]">Email</th>
                                    <th class="py-3 px-6 text-left text-sm font-semibold uppercase tracking-wider border-b border-[#7B61FF]">Phone</th>
                                    <th class="py-3 px-6 text-left text-sm font-semibold uppercase tracking-wider border-b border-[#7B61FF]">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                <?php
                                    require_once "../db.php";
                                    $sql = "SELECT * FROM user";
                                    $hasil = $db->query($sql);

                                    while ($row = $hasil->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <tr>
                                    <td class="py-4 px-6 text-sm text-gray-900 border-b border-[#7B61FF]"><?= $row['id_user'] ?></td>
                                    <td class="py-4 px-6 text-sm text-gray-900 border-b border-[#7B61FF]"><?= $row['nama'] ?></td>
                                    <td class="py-4 px-6 text-sm text-gray-900 border-b border-[#7B61FF]"><?= $row['email'] ?></td>
                                    <td class="py-4 px-6 text-sm text-gray-900 border-b border-[#7B61FF]"><?= $row['phone'] ?></td>
                                    <td class="py-4 px-6 text-sm border-b border-[#7B61FF]">
                                        <a href="#" class="text-red-500 hover:text-red-700 border-[#7B61FF] delete-btn" data-event-id="<?= $row['id_user'] ?>">Delete User</a>

                                        <!-- Form yang akan dikirim saat event dihapus -->
                                        <form id="deleteForm_<?= $row['id_user'] ?>" action="delete_user.php?id_user=<?= $row['id_user'] ?>" method="POST" style="display:none;">
                                            <input type="hidden" name="id_user" value="<?= $row['id_user'] ?>">
                                        </form>
                                        <a href="history.php?id_user=<?= $row['id_user'] ?>" class="text-blue-500 hover:text-blue-700 border-[#7B61FF] ml-4">History Partisipan</a>
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
                <li><a href="#" class="hover:text-blue-300">Add Event</a></li>
                <li><a href="#" class="hover:text-blue-300">User Management</a></li>
                <li><a href="#" class="hover:text-blue-300">Add Admin</a></li>
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
            $('table').DataTable(); 
        });
        // Ketika tombol hapus diklik
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function() {
        var eventId = this.getAttribute('data-event-id');
        Swal.fire({
            title: 'Hapus Event',
            text: 'Apakah Anda yakin ingin menghapus user ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Tidak, Batalkan'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form yang sesuai untuk menghapus event
                document.getElementById('deleteForm_' + eventId).submit();
            }
        });
    });
});
    </script>
</body>
</html>
