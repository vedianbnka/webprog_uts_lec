<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard - Konserhub</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="icon" href="../brand/icon.png" type="image/x-icon">
        <link
            href="https://cdn.datatables.net/v/dt/dt-2.1.5/datatables.min.css"
            rel="stylesheet">
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
                <!-- Header -->
                <header class="bg-white shadow p-4 flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-black">List Admin</h2>
                    <div class="text-gray-700">Welcome,
                        <?= $_SESSION['nama']; ?></div>
                </header>

                <!-- Content -->
                <main class="p-6 bg-gray-100">
                    <!-- Manage Users Section -->
                    <section class="bg-white p-6 rounded-lg shadow-lg mb-8">
                        <h3 class="text-xl font-semibold text-black mb-4">Manage Admin</h3>
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
                        <button
                            class="bg-[#7B61FF] hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                            <a href="add_admin.php" class="text-white-700 hover:underline">Add Admin</a>
                        </button>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-[#7B61FF] text-white">
                                    <tr>
                                        <th
                                            class="py-3 px-6 text-left text-sm font-semibold uppercase tracking-wider border-b border-[#7B61FF]">ID Admin</th>
                                        <th
                                            class="py-3 px-6 text-left text-sm font-semibold uppercase tracking-wider border-b border-[#7B61FF]">Nama</th>
                                        <th
                                            class="py-3 px-6 text-left text-sm font-semibold uppercase tracking-wider border-b border-[#7B61FF]">Email</th>
                                        <th
                                            class="py-3 px-6 text-left text-sm font-semibold uppercase tracking-wider border-b border-[#7B61FF]">Phone</th>
                                        <th
                                            class="py-3 px-6 text-left text-sm font-semibold uppercase tracking-wider border-b border-[#7B61FF]">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700">
                                    <?php
                                    require_once "../db.php";
                                    $sql = "SELECT * FROM admin";
                                    $hasil = $db->query($sql);

                                    while ($row = $hasil->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <tr>
                                        <td class="py-4 px-6 text-sm text-gray-900 border-b border-[#7B61FF]"><?= $row['id_user'] ?></td>
                                        <td class="py-4 px-6 text-sm text-gray-900 border-b border-[#7B61FF]"><?= $row['nama'] ?></td>
                                        <td class="py-4 px-6 text-sm text-gray-900 border-b border-[#7B61FF]"><?= $row['email'] ?></td>
                                        <td class="py-4 px-6 text-sm text-gray-900 border-b border-[#7B61FF]"><?= $row['phone'] ?></td>
                                        <td class="py-4 px-6 text-sm border-b border-[#7B61FF]">
                                            <a
                                                href="#"
                                                class="text-red-500 hover:text-red-700 border-[#7B61FF] delete-btn"
                                                data-event-id="<?= $row['id_user'] ?>">Delete Admin</a>

                                            <!-- Form yang akan dikirim saat event dihapus -->
                                            <form
                                                id="deleteForm_<?= $row['id_user'] ?>"
                                                action="delete_admin.php?id_user=<?= $row['id_user'] ?>"
                                                method="POST"
                                                style="display:none;">
                                                <input type="hidden" name="id_user" value="<?= $row['id_user'] ?>">
                                            </form>
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
            $('table').DataTable();
        });
        // Ketika tombol hapus diklik
        document
            .querySelectorAll('.delete-btn')
            .forEach(button => {
                button.addEventListener('click', function () {
                    var eventId = this.getAttribute('data-event-id');
                    Swal
                        .fire({
                            title: 'Hapus Event',
                            text: 'Apakah Anda yakin ingin menghapus admin ini?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Hapus',
                            cancelButtonText: 'Tidak, Batalkan'
                        })
                        .then((result) => {
                            if (result.isConfirmed) {
                                // Submit form yang sesuai untuk menghapus event
                                document
                                    .getElementById('deleteForm_' + eventId)
                                    .submit();
                            }
                        });
                });
            });
    </script>
</body>
</html>