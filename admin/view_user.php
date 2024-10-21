<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Konserhub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="icon.png" type="image/x-icon">
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.5/datatables.min.css" rel="stylesheet">
    
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
    <div class="flex flex-col md:flex-row">
    <aside class="w-full lg:w-64 bg-[#7B61FF] h-auto lg:h-screen p-4">
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
                <li>
                    <a href="../admin/add_admin.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Add Admin</a>
                </li>
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
                <h2 class="text-2xl font-bold text-black">User Management</h2>
                <h3>Selamat Datang, <?php echo isset($_SESSION['admin_name']) ? htmlspecialchars($_SESSION['admin_name']) : 'Admin'; ?></h3>
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
                                        <a href="delete_user.php?id_user=<?= $row['id_user'] ?>" class="text-red-500 hover:text-red-700 border-[#7B61FF]">Delete User</a>
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

                <footer class="bg-black py-4 mt-8">
                    <div class="text-center text-white">
                        © 2024 Konserhub Admin. All rights reserved.
                    </div>
                </footer>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.1.5/datatables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('table').DataTable(); 
        });
    </script>
</body>
</html>
