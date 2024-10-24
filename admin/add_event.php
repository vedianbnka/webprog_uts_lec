<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Admin Dashboard - Konserhub</title>
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

        setInterval(checkSession, 1000);

        function toggleFields(ticketType) {
            const fields = document.getElementById(ticketType + "-fields");
            if (document.getElementById(ticketType).checked) {
                fields.classList.remove("hidden");
            } else {
                fields.classList.add("hidden");
            }
        }

        function toggleMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
        
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @media (min-width: 1024px) {
            #mobile-menu {
                display: flex; /* Show the menu on larger screens */
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div>
        <header class="bg-[#7B61FF] text-white flex justify-between items-center p-4">
            <div class="flex items-center space-x-4">
                <img src="../brand/logo_white.png" alt="Website Logo" class="h-12 w-auto">
            </div>
            <button id="navigasi" class="bg-[#7B61FF] text-white p-2 rounded-md focus:outline-none lg:hidden" onclick="toggleMenu()">☰</button>
        </header>

        <nav class="bg-[#7B61FF] hidden lg:flex lg:flex-row items-center justify-center w-full py-4" id="mobile-menu">
            <ul class="flex flex-col lg:flex-row space-y-4 lg:space-y-0 lg:space-x-8">
                <li><a href="index.php" class="text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Dashboard</a></li>
                <li><a href="add_event.php" class="text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Add Events</a></li>
                <li><a href="view_user.php" class="text-white py-2 px-4 rounded hover:bg-[#6A52E0]">User Management</a></li>
                <li><a href="list_admin.php" class="text-white py-2 px-4 rounded hover:bg-[#6A52E0]">List Admin</a></li>
                <li><a href="../logout.php" class="text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Logout</a></li>
            </ul>
        </nav>

    <main class="flex-1 p-4">
        <!-- Header -->
        <header class="bg-white shadow p-4 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-black">Add Event</h2>
        </header>

        <!-- Add Event Form -->
        <form action="add_event_proses.php" method="POST" class="bg-white p-4 border rounded shadow max-w-lg mx-auto mt-10" enctype="multipart/form-data">
            <h1 class="text-center text-lg font-semibold mb-3">Add Event</h1>

            <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                <div class="bg-red-100 text-red-800 p-2 rounded mb-3 text-sm">
                    File type not supported
                </div>
            <?php endif; ?>

            <div class="mb-2">
                <label for="nama_event" class="block text-sm">Nama Event</label>
                <input type="text" id="nama_event" name="nama_event" class="w-full px-2 py-1 border rounded" required autocomplete="off"/>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-2">
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

            <!-- Ticket Types Section -->
            <div class="mb-2">
                <label class="block text-sm">Tipe Tiket</label>

                <!-- VVIP -->
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="vvip" name="tipe_tiket[]" value="vvip" class="rounded" onchange="toggleFields('vvip')"/>
                    <label for="vvip" class="text-sm">VVIP</label>
                </div>
                <div id="vvip-fields" class="hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <input type="text" id="vvip-harga" name="vvip_harga" placeholder="Harga VVIP" class="w-full px-2 py-1 border rounded"/>
                        <input type="number" id="vvip-kuota" name="vvip_kuota" placeholder="Kuota VVIP" class="w-full px-2 py-1 border rounded"/>
                    </div>
                </div>

                <!-- VIP -->
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="vip" name="tipe_tiket[]" value="vip" class="rounded" onchange="toggleFields('vip')"/>
                    <label for="vip" class="text-sm">VIP</label>
                </div>
                <div id="vip-fields" class="hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <input type="text" id="vip-harga" name="vip_harga" placeholder="Harga VIP" class="w-full px-2 py-1 border rounded"/>
                        <input type="number" id="vip-kuota" name="vip_kuota" placeholder="Kuota VIP" class="w-full px-2 py-1 border rounded"/>
                    </div>
                </div>

                <!-- CAT 1 -->
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="cat1" name="tipe_tiket[]" value="cat1" class="rounded" onchange="toggleFields('cat1')"/>
                    <label for="cat1" class="text-sm">CAT 1</label>
                </div>
                <div id="cat1-fields" class="hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <input type="text" id="cat1-harga" name="cat1_harga" placeholder="Harga CAT 1" class="w-full px-2 py-1 border rounded"/>
                        <input type="number" id="cat1-kuota" name="cat1_kuota" placeholder="Kuota CAT 1" class="w-full px-2 py-1 border rounded"/>
                    </div>
                </div>

                <!-- CAT 2 -->
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="cat2" name="tipe_tiket[]" value="cat2" class="rounded" onchange="toggleFields('cat2')"/>
                    <label for="cat2" class="text-sm">CAT 2</label>
                </div>
                <div id="cat2-fields" class="hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <input type="text" id="cat2-harga" name="cat2_harga" placeholder="Harga CAT 2" class="w-full px-2 py-1 border rounded"/>
                        <input type="number" id="cat2-kuota" name="cat2_kuota" placeholder="Kuota CAT 2" class="w-full px-2 py-1 border rounded"/>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="cat3" name="tipe_tiket[]" value="cat3" class="rounded" onchange="toggleFields('cat3')"/>
                    <label for="cat3" class="text-sm">CAT 3</label>
                </div>
                <div id="cat3-fields" class="hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <input type="text" id="cat3-harga" name="cat3_harga" placeholder="Harga CAT 3" class="w-full px-2 py-1 border rounded"/>
                        <input type="number" id="cat3-kuota" name="cat3_kuota" placeholder="Kuota CAT 3" class="w-full px-2 py-1 border rounded"/>
                    </div>
                </div>
            </div>

            <div class="mb-2">
                <label for="banner_event" class="block text-sm">Upload Poster</label>
                <input type="file" id="banner_event" name="banner_event" class="w-full px-2 py-1 border rounded" required/>
            </div>

            <div class="mt-4 text-center">
                <button type="submit" class="bg-[#7B61FF] hover:bg-[#6A52E0] text-white px-4 py-2 rounded" id="submit-btn">Add Event</button>
            </div>
        </form>
    </main>
<script>
    document.getElementById("submit-btn").addEventListener("click", function (event) {
        event.preventDefault(); // Mencegah form langsung submit

        Swal.fire({
            title: 'Konfirmasi Add Event',
            text: 'Apakah data yang anda input sudah benar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, tambahkan',
            cancelButtonText: 'Mau cek lagi'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.closest("form").submit(); // Kirim form jika user mengonfirmasi
            }
        });
    });
</script>
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
