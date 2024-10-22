<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="icon.png" type="image/x-icon"/>
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

        
    input[type="number"]:hover {
        border-color: #7B61FF;
        box-shadow: 0 0 5px rgba(123, 97, 255, 0.5);
        transition: 0.3s;
    }
    .form-group {
        margin-bottom: 10px;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
    }
    .form-group input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>

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

<?php
    require_once "../db.php";
    $id_event = $_GET['id_event'];
    $sql = "SELECT * FROM event_konser WHERE id_event = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id_event]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<body class="bg-gray-100">
<div class="min-h-screen flex flex-col lg:flex-row">
    <!-- Sidebar -->
    <aside class="w-full lg:w-64 bg-[#7B61FF] p-4 lg:h-screen">
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

    <!-- Main Content -->
    <main class="flex-1 p-4">
        <!-- Header -->
        <header class="bg-white shadow p-4 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-black">Edit Event</h2>
        </header>

        <!-- Edit Event Form -->
        <form action="edit_kuota_proses.php?id_event=<?= $event['id_event'] ?>" method="POST" class="bg-white p-5 border rounded shadow max-w-2xl mx-auto mt-20 animasi" enctype="multipart/form-data">
        <h1 class="text-center text-lg font-semibold mb-3">Edit Event</h1>

            <div class="mb-2">
                <label for="nama_event" class="block text-sm">Nama Event</label>
                <input type="text" id="nama_event" name="nama_event" class="w-full px-2 py-1 border rounded" value="<?= $event['nama_event'] ?>" readonly/>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-2">
                <div>
                    <label for="tanggal" class="block text-sm">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" class="w-full px-2 py-1 border rounded" value="<?= $event['tanggal'] ?>" readonly/>
                </div>
            </div>
            <?php
                $sql = "SELECT * FROM tiket WHERE id_event = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$event['id_event']]);
                $tiket = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($tiket as $tiket) {
                    if ($tiket['tipe_tiket'] == 'VVIP') {
            ?>
            <div class="form-group">
                <label for="tipe_tiket"><?= $tiket['tipe_tiket'] ?></label>
                <input type="number" id="kuota" name="kuota_VVIP" class="form-control" value="<?= $tiket['kuota'] ?>" required autocomplete="off">            </div>
            <?php
                }
                if ($tiket['tipe_tiket'] == 'VIP') {
            ?>
            <div class="form-group">
                <label for="tipe_tiket"><?= $tiket['tipe_tiket'] ?></label>
                <input type="number" id="kuota" name="kuota_VIP" class="form-control" value="<?= $tiket['kuota'] ?>" required autocomplete="off">            </div>
            <?php
                }
                if ($tiket['tipe_tiket'] == 'CAT 1') {
            ?>
            <div class="form-group">
                <label for="tipe_tiket"><?= $tiket['tipe_tiket'] ?></label>
                <input type="number" id="kuota" name="kuota_CAT1" class="form-control" value="<?= $tiket['kuota'] ?>" required autocomplete="off">            </div>
            <?php
                }
                if ($tiket['tipe_tiket'] == 'CAT 2') {
            ?>
            <div class="form-group">
                <label for="tipe_tiket"><?= $tiket['tipe_tiket'] ?></label>
                <input type="number" id="kuota" name="kuota_CAT2" class="form-control" value="<?= $tiket['kuota'] ?>" required autocomplete="off">            </div>
            <?php
                }
                if ($tiket['tipe_tiket'] == 'CAT 3') {
            ?>
            <div class="form-group">
                <label for="tipe_tiket"><?= $tiket['tipe_tiket'] ?></label>
                <input type="number" id="kuota" name="kuota_CAT3" class="form-control" value="<?= $tiket['kuota'] ?>" required autocomplete="off">            </div>
            <?php
                }}
            ?>
            <div class="mt-4 text-center">
                <button type="submit" class="bg-[#7B61FF] hover:bg-[#6A52E0] text-white px-4 py-2 rounded">Add Event</button>
            </div>
            
        </form>

    </main>
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
            <h5 class="font-semibold text-lg mb-4">021 5993693 / +62 354168293</h5>
        </div>
    </div>

    <div class="border-t border-gray-600 mt-8 pt-4 text-center">
        <p class="text-sm">&copy;2024 Konserhub. All rights reserved.</p>
    </div>
</footer>
</body>
</html>
