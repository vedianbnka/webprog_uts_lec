<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../brand/icon.png" type="image/x-icon">
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
<?php
session_start();
require_once "../db.php";

$sql = "SELECT * FROM event_konser WHERE id_event = " . $_GET['id_event'];
$event = $db->query($sql)->fetch(PDO::FETCH_ASSOC);
?>
<body class="bg-gray-100">
    <div class="flex flex-col md:flex-row">
        <aside class=" lg:w-54 bg-[#7B61FF] h-auto lg:h-screen p-4">
            <img src="../brand/logo_white.png" alt="Website Logo" class="flex justify-start w-32 md:w-40 lg:w-32">
            <nav>
                <ul class="space-y-4 mt-4">
                    <li><a href="index.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Dashboard</a></li>
                    <li><a href="add_event.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Add Events</a></li>
                    <li><a href="index.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Participants</a></li>
                    <li><a href="view_user.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">User Management</a></li>
                    <li>                        
                        <a href="list_admin.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">List Admin</a>
                    </li>
                    <li><a href="#" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Settings</a></li>
                    <li><a href="../logout.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Logout</a></li>
                </ul>
            </nav>
        </aside>
        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
            <header class="bg-white shadow p-4 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-black">Edit Event</h2>
            </header>

            <!-- Content -->
            <main class="p-6 bg-gray-100">
                <form action="edit_event_proses.php?id_event=<?= $event['id_event'] ?>" method="POST" class="max-w-md mx-auto p-4 border rounded-lg bg-white shadow-lg space-y-4" enctype="multipart/form-data">
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="mb-3 text-green-700 bg-green-100 p-3 rounded-md text-sm">
                            <?php 
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="mb-3 text-red-700 bg-red-100 p-3 rounded-md text-sm">
                            <?php 
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <div>
                        <label for="nama_event" class="block text-sm font-medium text-gray-700">Nama Event</label>
                        <input type="text" id="nama_event" name="nama_event" class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-gray-900 focus:ring-indigo-500 focus:border-indigo-500 text-sm" value="<?= $event['nama_event'] ?>" required autocomplete="off">
                    </div>

                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal" class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-gray-900 focus:ring-indigo-500 focus:border-indigo-500 text-sm" value="<?= $event['tanggal'] ?>" required autocomplete="off">
                    </div>

                    <div>
                        <label for="waktu" class="block text-sm font-medium text-gray-700">Waktu</label>
                        <input type="time" id="waktu" name="waktu" class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-gray-900 focus:ring-indigo-500 focus:border-indigo-500 text-sm" value="<?= $event['waktu'] ?>" required autocomplete="off">
                    </div>

                    <div>
                        <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi</label>
                        <input type="text" id="lokasi" name="lokasi" class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-gray-900 focus:ring-indigo-500 focus:border-indigo-500 text-sm" value="<?= $event['lokasi'] ?>" required autocomplete="off">
                    </div>

                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <input type="text" id="deskripsi" name="deskripsi" class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-gray-900 focus:ring-indigo-500 focus:border-indigo-500 text-sm" value="<?= $event['deskripsi'] ?>" required autocomplete="off">
                    </div>

                    <div>
                        <label for="banner_event" class="block text-sm font-medium text-gray-700">Banner Event</label>
                        <input type="file" id="banner_event" name="banner_event" class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-gray-900 focus:ring-indigo-500 focus:border-indigo-500 text-sm" required>
                    </div>

                    <button type="submit" name="add_event" class="w-full bg-[#7B61FF] hover:bg-[#6A52E0] text-white font-semibold py-2 rounded-md text-sm focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-50">Edit Event</button>
                    <a href="javascript:history.back()" class="block w-full text-center bg-gray-500 text-white font-semibold py-2 rounded-md text-sm hover:bg-gray-600 focus:ring-4 focus:ring-gray-400 focus:ring-opacity-50">Back</a>
                </form>

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
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
