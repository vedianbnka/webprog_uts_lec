<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="icon.png" type="image/x-icon">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @keyframes slideSide {
            0% {
                transform: translateX(-100px);
                opacity: 0;
            }
            100% {
                transform: translateX(0px);
                opacity: 1;
            }
        }
        .animasi {
            animation: slideSide 1s;
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
                    <li><a href="../admin/add_admin.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Add Admin</a></li>
                    <li><a href="#" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Settings</a></li>
                    <li><a href="#" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Logout</a></li>
                </ul>
            </nav>
        </aside>
        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
            <header class="bg-white shadow p-4 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-black">Edit Event</h2>
                <div class="text-gray-700">Welcome, Admin</div>
            </header>

            <!-- Content -->
            <main class="p-6 bg-gray-100">
                <form action="edit_event_proses.php?id_event=<?= $event['id_event'] ?>" method="POST" class="p-5 border rounded bg-white shadow animasi" enctype="multipart/form-data">
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

                    <div class="form-group">
                        <label for="nama_event">Nama Event</label>
                        <input type="text" id="nama_event" name="nama_event" class="form-control" value="<?= $event['nama_event'] ?>" required="required" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal" class="form-control" value="<?= $event['tanggal'] ?>" required="required" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="waktu">Waktu</label>
                        <input type="time" id="waktu" name="waktu" class="form-control" value="<?= $event['waktu'] ?>" required="required" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" id="lokasi" name="lokasi" class="form-control" value="<?= $event['lokasi'] ?>" required="required" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" id="deskripsi" name="deskripsi" class="form-control" value="<?= $event['deskripsi'] ?>" required="required" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="banner_event">Banner Event</label>
                        <input type="file" id="banner_event" name="banner_event" class="form-control" required="required">
                    </div>

                    <button type="submit" name="add_event" class="btn btn-primary btn-block">Edit Event</button>
                </form>
            </main>
        </div>
    </div>
    <footer class="bg-blue-900 bg-opacity-80 text-white py-8">
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- About Company Section -->
            <div>
                <h4 class="font-semibold text-lg mb-4">About Company</h4>
                <p class="text-sm">2-c-20, Kansua, Kota Rajasthan-324004</p>
                <div class="flex space-x-4 mt-4">
                    <!-- Social Media Icons -->
                    <a href="#"><img src="path-to-icon/facebook-icon.svg" alt="Facebook" class="w-6 h-6"></a>
                    <a href="#"><img src="path-to-icon/whatsapp-icon.svg" alt="WhatsApp" class="w-6 h-6"></a>
                    <a href="#"><img src="path-to-icon/youtube-icon.svg" alt="YouTube" class="w-6 h-6"></a>
                    <a href="#"><img src="path-to-icon/instagram-icon.svg" alt="Instagram" class="w-6 h-6"></a>
                </div>
            </div>

            <!-- Service Section -->
            <div>
                <h4 class="font-semibold text-lg mb-4">Service</h4>
                <ul class="text-sm space-y-2">
                    <li><a href="#" class="hover:text-blue-300">Web Design</a></li>
                    <li><a href="#" class="hover:text-blue-300">Digital Marketing</a></li>
                    <li><a href="#" class="hover:text-blue-300">IT Management</a></li>
                    <li><a href="#" class="hover:text-blue-300">Cloud Services</a></li>
                    <li><a href="#" class="hover:text-blue-300">Machine Learning</a></li>
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
                    <div>
                        <input type="checkbox" id="subscribe" class="mr-2">
                        <label for="subscribe" class="text-sm">Subscribe to our newsletter</label>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-md">Submit</button>
                </form>
            </div>
        </div>

        <div class="border-t border-gray-600 mt-8 pt-4 text-center">
            <p class="text-sm">&copy; copy right. 2024</p>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
