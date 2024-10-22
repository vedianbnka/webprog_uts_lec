<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../brand/icon.png" type="image/x-icon">

    <script>
        function checkSession() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "../check_session.php", true);
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

        function goBack() {
            window.history.back();
        }
    </script>

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

        /* Ensure footer sticks to the bottom */
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        footer {
            margin-top: auto;
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Main Wrapper -->
    <div class="flex flex-col lg:flex-row min-h-screen">
        
        <!-- Sidebar -->
        <aside class="w-full lg:w-64 bg-[#7B61FF] p-4 flex-shrink-0">
            <img src="../brand/logo_white.png" alt="Website Logo" class="mb-4 w-32 mx-auto lg:mx-0">
            <nav>
                <ul class="space-y-4">
                    <li><a href="index.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Dashboard</a></li>
                    <li><a href="add_event.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Add Events</a></li>
                    <li><a href="view_user.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">User Management</a></li>
                    <li><a href="list_admin.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">List Admin</a></li>
                    <li><a href="../logout.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow flex justify-center items-center p-4 lg:p-8">
            <div class="max-w-md mx-auto p-4 border rounded-lg bg-white shadow-lg space-y-4">
                <?php
                    require_once ("../db.php");

                    $sql = "SELECT * FROM event_konser WHERE id_event = ?";
                    $statement = $db->prepare($sql);
                    $statement->execute([$_GET['id_event']]);
                    $event = $statement->fetch();
                ?>
                
                <!-- Event Title -->
                <h1 class="text-2xl font-semibold text-[#7B61FF] mb-4 text-center">
                    <?php echo $event['nama_event']; ?>
                </h1>

                <!-- Event Banner -->
                <img src="../upload/<?php echo $event['banner_event']; ?>" alt="Event Banner" class="w-full h-48 object-cover rounded-lg mb-4 shadow-md">
                
                <!-- Event Details (Date, Time, Location) -->
                <div class="grid grid-cols-1 gap-2 md:grid-cols-3 mb-4">
                    <div class="flex items-center text-gray-700">
                        <span class="text-lg">📅 :</span>
                        <span class="ml-2 text-sm"><?php echo $event['tanggal']; ?></span>
                    </div>
                    <div class="flex items-center text-gray-700">
                        <span class="text-lg">⏰ :</span>
                        <span class="ml-2 text-sm"><?php echo $event['waktu']; ?></span>
                    </div>
                    <div class="flex items-center text-gray-700">
                        <span class="text-lg">📍 :</span>
                        <span class="ml-2 text-sm"><?php echo $event['lokasi']; ?></span>
                    </div>
                </div>

                <!-- Event Description -->
                <p class="text-gray-800 text-justify leading-relaxed">
                    <?php echo nl2br($event['deskripsi']); ?>
                </p>

                <!-- Back Button -->
                <div class="flex justify-center mt-4">
                    <button 
                        onclick="goBack()" 
                        class="px-4 py-2 bg-[#7B61FF] text-white rounded-md hover:bg-[#6a51e2] transition duration-200 ease-in-out"
                    >
                        Back
                    </button>
                </div>
            </div>
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
