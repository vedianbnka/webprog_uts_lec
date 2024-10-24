<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Event</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="icon" href="../brand/icon.png" type="image/x-icon">
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

<?php
    require_once "../db.php";
    $id_event = $_GET['id_event'];
    $sql = "SELECT * FROM event_konser WHERE id_event = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id_event]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
?>

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

        <!-- Main Content -->
        <main class="flex-1 p-4">
            <!-- Header -->
            <header class="bg-white shadow p-4 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-black">Edit Kuota
                </h2>
            </header>

            <!-- Edit Event Form -->
            <form
                action="edit_kuota_proses.php?id_event=<?= $event['id_event'] ?>"
                method="POST"
                class="bg-white p-5 border rounded shadow max-w-2xl mx-auto mt-20 animasi"
                enctype="multipart/form-data">

                <div class="mb-2">
                    <label for="nama_event" class="block text-sm">Nama Event</label>
                    <input
                        type="text"
                        id="nama_event"
                        name="nama_event"
                        class="w-full px-2 py-1 border rounded"
                        value="<?= $event['nama_event'] ?>"
                        readonly="readonly"/>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-2">
                    <div>
                        <label for="tanggal" class="block text-sm">Tanggal</label>
                        <input
                            type="date"
                            id="tanggal"
                            name="tanggal"
                            class="w-full px-2 py-1 border rounded"
                            value="<?= $event['tanggal'] ?>"
                            readonly="readonly"/>
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
                    <input
                        type="number"
                        id="kuota"
                        name="kuota_VVIP"
                        class="form-control"
                        value="<?= $tiket['kuota'] ?>"
                        required="required"
                        autocomplete="off">
                </div>
                <?php
                }
                if ($tiket['tipe_tiket'] == 'VIP') {
            ?>
                <div class="form-group">
                    <label for="tipe_tiket"><?= $tiket['tipe_tiket'] ?></label>
                    <input
                        type="number"
                        id="kuota"
                        name="kuota_VIP"
                        class="form-control"
                        value="<?= $tiket['kuota'] ?>"
                        required="required"
                        autocomplete="off">
                </div>
                <?php
                }
                if ($tiket['tipe_tiket'] == 'CAT 1') {
            ?>
                <div class="form-group">
                    <label for="tipe_tiket"><?= $tiket['tipe_tiket'] ?></label>
                    <input
                        type="number"
                        id="kuota"
                        name="kuota_CAT1"
                        class="form-control"
                        value="<?= $tiket['kuota'] ?>"
                        required="required"
                        autocomplete="off">
                </div>
                <?php
                }
                if ($tiket['tipe_tiket'] == 'CAT 2') {
            ?>
                <div class="form-group">
                    <label for="tipe_tiket"><?= $tiket['tipe_tiket'] ?></label>
                    <input
                        type="number"
                        id="kuota"
                        name="kuota_CAT2"
                        class="form-control"
                        value="<?= $tiket['kuota'] ?>"
                        required="required"
                        autocomplete="off">
                </div>
                <?php
                }
                if ($tiket['tipe_tiket'] == 'CAT 3') {
            ?>
                <div class="form-group">
                    <label for="tipe_tiket"><?= $tiket['tipe_tiket'] ?></label>
                    <input
                        type="number"
                        id="kuota"
                        name="kuota_CAT3"
                        class="form-control"
                        value="<?= $tiket['kuota'] ?>"
                        required="required"
                        autocomplete="off">
                </div>
                <?php
                }}
            ?>
                <button
                    type="submit"
                    name="add_event"
                    class="w-full bg-[#7B61FF] hover:bg-[#6A52E0] text-white font-semibold py-2 rounded-md text-sm focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-50">Edit Kuota</button>
                <a
                    href="javascript:history.back()"
                    class="mt-3 block w-full text-center bg-gray-500 text-white font-semibold py-2 rounded-md text-sm hover:bg-gray-600 focus:ring-4 focus:ring-gray-400 focus:ring-opacity-50">Back</a>
            </form>
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
</body>
</html>