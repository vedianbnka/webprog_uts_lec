<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Admin Dashboard - Konserhub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="icon.png" type="image/x-icon"/>
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

        function toggleFields(ticketType) {
            const fields = document.getElementById(ticketType + "-fields");
            if (document.getElementById(ticketType).checked) {
                fields.classList.remove("hidden");
            } else {
                fields.classList.add("hidden");
            }
        }
    </script>
</head>
<body class="bg-gray-100">
<div class="flex items-stretch min-h-screen">
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
        <!-- Header -->
        <header class="bg-white shadow p-4 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-black">Add Event</h2>
            <div class="text-gray-700">Welcome, Admin</div>
        </header>

        <!-- Add Event Form -->
    <form action="add_event_proses.php" method="POST" class="p-3 border rounded bg-white shadow animasi max-w-md mx-auto mt-10" enctype="multipart/form-data">
    <h1 class="text-center text-lg font-semibold mb-3 ">Add Event</h1>
    
    <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
        <div class="bg-red-100 text-red-800 p-2 rounded mb-3 text-sm">
            File type not supported
        </div>
    <?php endif; ?>

    <div class="mb-2">
        <label for="nama_event" class="block text-sm">Nama Event</label>
        <input type="text" id="nama_event" name="nama_event" class="w-full px-2 py-1 border rounded" required autocomplete="off"/>
    </div>

    <div class="grid grid-cols-2 gap-2 mb-2">
        <div>
            <label for="tanggal" class="block text-sm">Tanggal</label>
            <input type="date" id="tanggal" name="tanggal" class="w-full px-2 py-1 border rounded" required autocomplete="off"/>
        </div>
        <div>
            <label for="waktu" class="block text-sm">Waktu</label>
            <input type="time" id="waktu" name="waktu" class="w-full px-2 py-1 border rounded" required autocomplete="off"/>
        </div>
    </div>

    <div class="mb-2">
        <label for="lokasi" class="block text-sm">Lokasi</label>
        <input type="text" id="lokasi" name="lokasi" class="w-full px-2 py-1 border rounded" required autocomplete="off"/>
    </div>

    <div class="mb-2">
        <label for="deskripsi" class="block text-sm">Deskripsi</label>
        <input type="text" id="deskripsi" name="deskripsi" class="w-full px-2 py-1 border rounded" required autocomplete="off"/>
    </div>

    <div class="mb-2">
        <label class="block text-sm">Tipe Tiket</label>

        <div class="flex items-center space-x-2">
            <input type="checkbox" id="vvip" name="tipe_tiket[]" value="vvip" class="rounded" onchange="toggleFields('vvip')"/>
            <label for="vvip" class="text-sm">VVIP</label>
        </div>
        <div id="vvip-fields" class="hidden">
            <div class="grid grid-cols-2 gap-2">
                <input type="text" id="vvip-harga" name="vvip_harga" placeholder="Harga VVIP" class="w-full px-2 py-1 border rounded"/>
                <input type="number" id="vvip-kuota" name="vvip_kuota" placeholder="Kuota VVIP" class="w-full px-2 py-1 border rounded"/>
                <input type="text" id="vvip-benefit" name="vvip_benefit" placeholder="Benefit VVIP" class="w-full px-2 py-1 border rounded col-span-2"/>
            </div>
        </div>

        <div class="flex items-center space-x-2">
            <input type="checkbox" id="vip" name="tipe_tiket[]" value="vip" class="rounded" onchange="toggleFields('vip')"/>
            <label for="vip" class="text-sm">VIP</label>
        </div>
        <div id="vip-fields" class="hidden">
            <div class="grid grid-cols-2 gap-2">
                <input type="text" id="vip-harga" name="vip_harga" placeholder="Harga VIP" class="w-full px-2 py-1 border rounded"/>
                <input type="number" id="vip-kuota" name="vip_kuota" placeholder="Kuota VIP" class="w-full px-2 py-1 border rounded"/>
                <input type="text" id="vip-benefit" name="vip_benefit" placeholder="Benefit VIP" class="w-full px-2 py-1 border rounded col-span-2"/>
            </div>
        </div>

        <!-- CAT 1 -->
        <div class="flex items-center space-x-2">
            <input type="checkbox" id="cat1" name="tipe_tiket[]" value="cat1" class="rounded" onchange="toggleFields('cat1')"/>
            <label for="cat1" class="text-sm">CAT 1</label>
        </div>
        <div id="cat1-fields" class="hidden">
            <div class="grid grid-cols-2 gap-2">
                <input type="text" id="cat1-harga" name="cat1_harga" placeholder="Harga CAT 1" class="w-full px-2 py-1 border rounded"/>
                <input type="number" id="cat1-kuota" name="cat1_kuota" placeholder="Kuota CAT 1" class="w-full px-2 py-1 border rounded"/>
                <input type="text" id="cat1-benefit" name="cat1_benefit" placeholder="Benefit CAT 1" class="w-full px-2 py-1 border rounded col-span-2"/>
            </div>
        </div>

        <!-- CAT 2 -->
        <div class="flex items-center space-x-2">
            <input type="checkbox" id="cat2" name="tipe_tiket[]" value="cat2" class="rounded" onchange="toggleFields('cat2')"/>
            <label for="cat2" class="text-sm">CAT 2</label>
        </div>
        <div id="cat2-fields" class="hidden">
            <div class="grid grid-cols-2 gap-2">
                <input type="text" id="cat2-harga" name="cat2_harga" placeholder="Harga CAT 2" class="w-full px-2 py-1 border rounded"/>
                <input type="number" id="cat2-kuota" name="cat2_kuota" placeholder="Kuota CAT 2" class="w-full px-2 py-1 border rounded"/>
                <input type="text" id="cat2-benefit" name="cat2_benefit" placeholder="Benefit CAT 2" class="w-full px-2 py-1 border rounded col-span-2"/>
            </div>
        </div>

        <!-- CAT 3 -->
        <div class="flex items-center space-x-2">
            <input type="checkbox" id="cat3" name="tipe_tiket[]" value="cat3" class="rounded" onchange="toggleFields('cat3')"/>
            <label for="cat3" class="text-sm">CAT 3</label>
        </div>
        <div id="cat3-fields" class="hidden">
            <div class="grid grid-cols-2 gap-2">
                <input type="text" id="cat3-harga" name="cat3_harga" placeholder="Harga CAT 3" class="w-full px-2 py-1 border rounded"/>
                <input type="number" id="cat3-kuota" name="cat3_kuota" placeholder="Kuota CAT 3" class="w-full px-2 py-1 border rounded"/>
                <input type="text" id="cat3-benefit" name="cat3_benefit" placeholder="Benefit CAT 3" class="w-full px-2 py-1 border rounded col-span-2"/>
            </div>
        </div>


    </div>

    <div class="mb-2">
        <label for="banner_event" class="block text-sm">Banner Event</label>
        <input type="file" id="banner_event" name="banner_event" class="w-full px-2 py-1 border rounded" required/>
    </div>

    <button type="submit" name="add_event" class="w-full bg-[#7B61FF] text-white font-semibold py-2 rounded hover:bg-purple-600 transition-colors">
        Add Event
    </button>
</form>


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
                <li><a href="#" class="hover:text-blue-300">Add Event</a></li>
                <li><a href="#" class="hover:text-blue-300">User Management</a></li>
                <li><a href="#" class="hover:text-blue-300">Add Admin</a></li>
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
</body>
</html>
