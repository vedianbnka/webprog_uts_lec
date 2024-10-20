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
    <title>Admin Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        setInterval(checkSession, 10000); // Mengecek sesi setiap 10 detik
    </script>

    <style>
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
<body class="bg-gray-100">

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

        <input type="text" id="search" placeholder="Cari Tiket..." class="mb-4 p-2 border border-gray-300 rounded" onkeyup="searchTickets()">

        <label for="ticketsPerPage" class="mr-2">Tampilkan:</label>
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
                        <th class="px-4 py-2 border-b">Nama Event</th>
                        <th class="px-4 py-2 border-b">Tanggal Register</th>
                        <th class="px-4 py-2 border-b">Tipe Tiket</th>
                        <th class="px-4 py-2 border-b">Jumlah Pembelian Tiket</th>
                        <th class="px-4 py-2 border-b">Bukti Pembayaran</th>
                        <th class="px-4 py-2 border-b">Status</th>
                        <th class="px-4 py-2 border-b">No. Tiket</th>
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
                        <td class="px-4 py-3 border-b"><?= $row['no_tiket'] == null ? '-' : $row['no_tiket'] ?></td>
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

    <br><br><br><br><br>

    <footer class="bg-black py-8 mt-20">
    <div class="container mx-auto px-4 text-center">
        <div class="flex flex-wrap justify-center space-x-6 md:space-x-10 mb-4">
            <a href="#" target="_blank">
                <img src="../brand/ig2.png" alt="Instagram" class="sosmed"> 
            </a>
            <a href="#" target="_blank">
                <img src="../brand/x.png" alt="X (Twitter)" class="sosmedx">
            </a>
            <a href="#" target="_blank">
                <img src="../brand/tiktok3.png" alt="TikTok" class="sosmed">
            </a>
        </div>
        
        <p class="text-white text-sm md:text-base lg:text-lg">© 2024 Konserhub. All rights reserved.</p>
        
        <div class="flex justify-center space-x-4 mt-4">
            <a href="#" class="text-gray-400 hover:text-white text-sm md:text-base">Privacy Policy</a>
            <a href="#" class="text-gray-400 hover:text-white text-sm md:text-base">Terms of Service</a>
            <a href="#" class="text-gray-400 hover:text-white text-sm md:text-base">Contact Us</a>
        </div>
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
                                <td class="px-4 py-3 border-b">${ticket.no_tiket == null ? '-' : ticket.no_tiket}</td>
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
