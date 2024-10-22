<?php
session_start();
require_once "../db.php";

$id_user = $_SESSION['id_user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konserhub | My Ticket</title>
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
        setInterval(checkSession, 1); // Mengecek sesi setiap 10 detik
    </script>

    <style>
        html, body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .container {
            flex: 1; /* Memungkinkan konten mengambil ruang yang tersedia */
        }   

        img {
            width: 100%;
            height: auto;
        }

        .slideshow {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 60vh;
            overflow: hidden;
            z-index: -1; 
        }

        .slideshow img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            position: absolute;
            transition: opacity 1s ease-in-out;
        }

        .slideshow img.active {
            opacity: 1;
        }

        .sosmed {
            width: 2.5rem;
            height: 2.5rem; 
        }

        .sosmedx {
            width: 2rem;
            height: 2rem;
            margin-top: 5px;
        }

        .sosmed:hover {
            transition: ease-in-out .2s;
            transform: scale(1.5);
        }

        .sosmedx:hover {
            transition: ease-in-out .2s;
            transform: scale(1.5);
        }

        .sosmed:not(:hover) {
            transition: ease-in-out .2s;
            transform: scale(1);
        }

        .sosmedx:not(:hover) {
            transition: ease-in-out .2s;
            transform: scale(1);
        }

        #mobile-menu {
            display: none;
            position: absolute; 
            left: 0;
            right: 0;
            background-color: white; 
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); 
            z-index: 50; 
            max-height: 0; 
            overflow: hidden;
            transition: max-height 0.3s ease-in-out; 
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="index.php" class="flex items-center space-x-2">
                <img src="../brand/logo1.png" alt="Website Logo" class="h-7 w-auto">
            </a>
            <div class="block lg:hidden">
                <button id="menu-button" class="focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
            <div class="hidden lg:flex space-x-6" id="menu">
                <a href="index.php" class="text-black hover:text-[#7B61FF]">Home</a>
                <a href="events.php" class="text-black hover:text-[#7B61FF]">Events</a>
                <a href="profile.php" class="text-black hover:text-[#7B61FF]">Profile</a>
                <a href="tiket.php" class="text-black hover:text-[#7B61FF]">My Ticket</a>
                <a href="../logout.php" class="text-black hover:text-[#7B61FF]">Logout</a>
            </div>
        </div>
        <!-- Dropdown Menu -->
        <div class="lg:hidden" id="mobile-menu" style="display: none;">
            <a href="index.php" class="block text-black hover:text-[#7B61FF] px-4 py-2">Home</a>
            <a href="events.php" class="block text-black hover:text-[#7B61FF] px-4 py-2">Events</a>
            <a href="profile.php" class="block text-black hover:text-[#7B61FF] px-4 py-2">Profile</a>
            <a href="tiket.php" class="block text-black hover:text-[#7B61FF] px-4 py-2">My Ticket</a>
            <a href="../logout.php" class="block text-black hover:text-[#7B61FF] px-4 py-2">Logout</a>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="mb-4 text-green-600 bg-green-100 p-3 rounded">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="mb-4 text-red-600 bg-red-100 p-3 rounded">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <h1 class="text-3xl font-bold text-black mb-6">My Ticket</h1>

        <input type="text" id="search" placeholder="Find Ticket..." class="mb-4 p-2 border border-gray-300 rounded" onkeyup="searchTickets()" autocomplete="off">

        <label for="ticketsPerPage" class="mr-2">Number of list:</label>
        <select id="ticketsPerPage" class="mb-4 p-2 border border-gray-300 rounded" onchange="updateTicketsPerPage()">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="15">15</option>
            <option value="20">20</option>
        </select>

        <div class="overflow-x-auto">
            <table id="ticketTable" class="min-w-full bg-white border border-gray-300 rounded-lg shadow-lg">
                <thead class="bg-[#7B61FF] text-white">
                    <tr>
                        <th class="px-4 py-2 border-b rounded-tl-lg">Nama Event</th>
                        <th class="px-4 py-2 border-b">Tanggal Register</th>
                        <th class="px-4 py-2 border-b">Tipe Tiket</th>
                        <th class="px-4 py-2 border-b">Jumlah Pembelian Tiket</th>
                        <th class="px-4 py-2 border-b">Bukti Pembayaran</th>
                        <th class="px-4 py-2 border-b">Status</th>
                        <th class="px-4 py-2 border-b rounded-tr-lg">No. Tiket</th>
                    </tr>
                </thead>
                <tbody id="ticketBody">
                    <?php
                        $sql = "SELECT * FROM list_partisipan_event AS p JOIN event_konser AS e ON p.id_event = e.id_event WHERE p.id_user = ?";
                        $statement = $db->prepare($sql);
                        $statement->execute([$id_user]);
                        $tickets = $statement->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($tickets as $row) {
                    ?>
                    <tr class="hover:bg-gray-100 transition duration-300">
                        <td class="px-4 py-3 border-b">
                            <a href="detail_event.php?id_event=<?= $row['id_event'] ?>" class="text-[#7B61FF] hover:underline">
                                <?= $row['nama_event'] ?>
                            </a>
                        </td>
                        <td class="px-4 py-3 border-b"><?= $row['tanggal_register'] ?></td>
                        <td class="px-4 py-3 border-b"><?= $row['tipe_tiket'] ?></td>
                        <td class="px-4 py-3 border-b"><?= $row['jumlah'] ?></td>
                        <td class="px-4 py-3 border-b">
                            <img class="w-20 h-auto rounded-md" src="../bukti_pembayaran/<?= $row['bukti_pembayaran'] ?>" alt="Bukti Pembayaran">
                        </td>
                        <td class="px-4 py-3 border-b"><?= $row['status'] ?></td>
                        <td class="px-4 py-3 border-b">
                        <a href="../qr.php?id_partisipan=<?= $row['id_partisipan'] ?>" target="_blank" class="text-[#7B61FF] hover:underline">My QR</a>
                    </td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="flex justify-between mt-4">
            <button onclick="prevPage()" id="prevBtn" class="bg-[#7B61FF] text-white p-2 rounded disabled:opacity-50" disabled>Prev</button>
            <button onclick="nextPage()" id="nextBtn" class="bg-[#7B61FF] text-white p-2 rounded disabled:opacity-50">Next</button>
        </div>

        <div class="mt-4">
            <span id="pageInfo" class="text-gray-700"></span>
        </div>
    </div> 


    <!-- Footer -->
    <footer class="bg-black bg-opacity-80 text-white py-8">
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
                    <li><a href="events.php" class="hover:text-blue-300">Event</a></li>
                    <li><a href="profile.php" class="hover:text-blue-300">Profile</a></li>
                    <li><a href="tiket.php" class="hover:text-blue-300">My Ticket</a></li>
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

    <script>
        let ticketsPerPage = 5; 
        let currentPage = 1;
        let tickets = <?= json_encode($tickets) ?>; 
        let filteredTickets = [...tickets]; 

        function renderTickets() {
            const ticketBody = document.getElementById('ticketBody');
            const pageInfo = document.getElementById('pageInfo');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');

            const totalTickets = filteredTickets.length;
            const totalPages = Math.ceil(totalTickets / ticketsPerPage);
            const startIndex = (currentPage - 1) * ticketsPerPage;
            const endIndex = startIndex + ticketsPerPage;

            ticketBody.innerHTML = '';

            filteredTickets.slice(startIndex, endIndex).forEach(ticket => {
                const row = `<tr class="hover:bg-gray-100 transition duration-300">
                                <td class="px-4 py-3 border-b">
                                    <a href="detail_event.php?id_event=${ticket.id_event}" class="text-[#7B61FF] hover:underline">${ticket.nama_event}</a>
                                </td>
                                <td class="px-4 py-3 border-b">${ticket.tanggal_register}</td>
                                <td class="px-4 py-3 border-b">${ticket.tipe_tiket}</td>
                                <td class="px-4 py-3 border-b">${ticket.jumlah}</td>
                                <td class="px-4 py-3 border-b">
                                    <img class="w-20 h-auto rounded-md" src="../bukti_pembayaran/${ticket.bukti_pembayaran}" alt="Bukti Pembayaran">
                                </td>
                                <td class="px-4 py-3 border-b">${ticket.status}</td>
                                <td class="px-4 py-3 border-b">
                                    ${ticket.no_tiket === null ? 'No. Tiket akan muncul setelah pembayaran anda di approve oleh admin kami.' : `<a href="../qr.php?id_partisipan=${ticket.id_partisipan}" target="_blank"  class="bg-[#7B61FF] text-white p-1 rounded disabled:opacity-50 hover:underline">My QR</a>`}
                                </td>
                            </tr>`;
                ticketBody.innerHTML += row;
            });

            pageInfo.innerText = `Halaman ${currentPage} dari ${totalPages}`;

            prevBtn.disabled = currentPage === 1;
            nextBtn.disabled = currentPage === totalPages;
        }

        function nextPage() {
            const totalPages = Math.ceil(filteredTickets.length / ticketsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderTickets();
            }
        }

        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                renderTickets();
            }
        }

        function searchTickets() {
            const searchInput = document.getElementById('search').value.toLowerCase();
            filteredTickets = tickets.filter(ticket => 
                ticket.nama_event.toLowerCase().includes(searchInput) ||
                ticket.tanggal_register.includes(searchInput) ||
                ticket.tipe_tiket.toLowerCase().includes(searchInput) ||
                ticket.jumlah.toString().includes(searchInput) ||
                ticket.status.toLowerCase().includes(searchInput)
            );

            currentPage = 1; 
            renderTickets();
        }

        function updateTicketsPerPage() {
            ticketsPerPage = parseInt(document.getElementById('ticketsPerPage').value);
            currentPage = 1; 
            renderTickets();
        }

        renderTickets();

        const menuButton = document.getElementById('menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        menuButton.addEventListener('click', () => {
            if (mobileMenu.style.display === 'none' || mobileMenu.style.display === '') {
                mobileMenu.style.display = 'block'; 
                mobileMenu.style.maxHeight = '0'; 
                setTimeout(() => {
                    mobileMenu.style.maxHeight = '500px'; 
                }, 10);
            } else {
                mobileMenu.style.maxHeight = '0'; 
                mobileMenu.addEventListener('transitionend', () => {
                    if (mobileMenu.style.maxHeight === '0px') {
                        mobileMenu.style.display = 'none'; 
                    }
                }, { once: true }); 
            }
        });
    </script>
</body>
</html>

