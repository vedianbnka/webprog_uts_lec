<?php
session_start();
require_once '../db.php';

// Tentukan jumlah event per halaman
$events_per_page = 12;

// Ambil nomor halaman dari parameter URL, jika tidak ada maka default ke halaman 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Hitung offset
$offset = ($page - 1) * $events_per_page;

// Query untuk menghitung total jumlah event
$total_events_sql = "SELECT COUNT(*) as total FROM event_konser WHERE status_event = 'open'";
$total_events_result = $db->query($total_events_sql);
$total_events = $total_events_result->fetch(PDO::FETCH_ASSOC)['total'];

// Query untuk mengambil event dengan paginasi
$sql = "SELECT * FROM event_konser WHERE status_event = 'open' LIMIT :limit OFFSET :offset";
$stmt = $db->prepare($sql);
$stmt->bindValue(':limit', $events_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$resultEvents = $stmt;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konserhub | Events</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../brand/icon.png" type="image/x-icon">
    <style>
        .slideshow {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 60vh; /* Adjust the height as needed */
            overflow: hidden;
            z-index: -1; /* Places the slideshow behind the content */
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

        .card {
            width: 300px; /* Adjust card width */
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

        #konten {
            margin-top: 12rem;
        }
    </style>
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

        //slideshow
        let currentSlide = 0;

        function showSlides() {
            const slides = document.querySelectorAll('.slideshow img');
            slides.forEach((slide, index) => {
                slide.classList.remove('active');
                if (index === currentSlide) {
                    slide.classList.add('active');
                }
            });
            currentSlide = (currentSlide + 1) % slides.length;
        }

        document.addEventListener('DOMContentLoaded', () => {
            showSlides();
            setInterval(showSlides, 5000); // Change slide every 5 seconds
        });
    </script>
</head>
<body class="bg-gray-100">

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

    <div class="slideshow">        
        <img src="slide/slide9.jpg" alt="Slide 1">
        <img src="slide/slide7.jpg" alt="Slide 2">
        <img src="slide/slide8.jpg" alt="Slide 3">
    </div>
    <!-- Content Section -->
    <section class="bg-transparent py-20 relative">
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl font-bold text-white" style="margin-top: 5rem;">
                Find concerts happening near you
            </h1>
        </div>
    </section>

<!-- Content Section -->
<section class="p-5 bg-white rounded shadow" id="konten"> 
    <h1 class="text-center text-3xl font-bold mb-5">Available Events</h1>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="mb-4 text-green-600 bg-green-100 p-3 rounded">
            <?php 
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
        </div>
    <?php endif; ?>

    <?php if ($resultEvents->rowCount() > 0): ?>
        <div class="grid grid-cols-1 gap-x-4 gap-y-6 md:grid-cols-2 lg:grid-cols-3">
            <?php while($row = $resultEvents->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="flex flex-col rounded-lg bg-white shadow-lg overflow-hidden transition-transform transform hover:scale-105">
                    <div class="relative h-40">
                        <?php if ($row['banner_event']): ?>
                            <img src="../upload/<?= htmlspecialchars($row['banner_event']) ?>" alt="banner_event" class="object-cover w-full h-full">
                        <?php else: ?>
                            <div class="flex items-center justify-center w-full h-full bg-gray-300 text-gray-600">No banner</div>
                        <?php endif; ?>
                    </div>
                    <div class="p-4">
                        <h2 class="mb-2 text-xl font-bold text-[#7B61FF] leading-snug tracking-normal antialiased">
                            <?= htmlspecialchars($row['nama_event']) ?>
                        </h2>
                        <p class="font-sans text-base font-light leading-relaxed text-gray-700 antialiased">
                            <strong>Tanggal:</strong> <?= htmlspecialchars($row['tanggal']) ?><br>
                            <strong>Waktu:</strong> <?= htmlspecialchars($row['waktu']) ?><br>
                            <strong>Lokasi:</strong> <?= htmlspecialchars($row['lokasi']) ?><br>
                            <strong>Deskripsi:</strong> <?= htmlspecialchars($row['deskripsi']) ?><br>
                            <strong>Partisipan:</strong> 
                            <?php
                                $sqlTickets = "SELECT * FROM tiket WHERE id_event = :id_event";
                                $stmtTickets = $db->prepare($sqlTickets);
                                $stmtTickets->bindParam(':id_event', $row['id_event'], PDO::PARAM_INT);
                                $stmtTickets->execute();

                                $kuota = 0;
                                $jumlah_sold = 0;

                                while ($ticket = $stmtTickets->fetch(PDO::FETCH_ASSOC)) {
                                    $jumlah_sold += $ticket['jumlah_sold'];
                                    $kuota += $ticket['kuota'];
                                }

                                echo $jumlah_sold . " / " . $kuota;
                            ?>
                        </p>
                    </div>
                    <div class="p-4">
                        <a href="regis.php?id_event=<?= htmlspecialchars($row['id_event']) ?>" class="block rounded-lg bg-[#7B61FF] py-3 text-center font-sans text-xs font-bold uppercase text-white shadow-md transition-all hover:bg-[#7B61FF]/90">
                            Register
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <div class="mt-10 flex justify-center">
            <?php for ($i = 1; $i <= ceil($total_events / $events_per_page); $i++): ?>
                <a href="?page=<?= $i ?>" class="mx-1 px-4 py-2 bg-<?= ($page == $i) ? '[#7B61FF]' : 'gray-300' ?> text-white rounded transition-colors hover:bg-[#7B61FF]">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>

    <?php else: ?>
        <div class="text-center mt-5">
            <p class="text-gray-600">Tidak ada event konser yang terbuka saat ini.</p>
        </div>
    <?php endif; ?>
</section>
    <!-- Footer -->
    <footer class="bg-black bg-opacity-80 text-white py-8 mt-10">
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
                        <a href="events.php" class="hover:text-blue-300">Event</a>
                    </li>
                    <li>
                        <a href="profile.php" class="hover:text-blue-300">Profile</a>
                    </li>
                    <li>
                        <a href="tiket.php" class="hover:text-blue-300">My Ticket</a>
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

        <div class="border-t border-gray-600 mt-8 pt-4 text-center">
            <p class="text-sm">&copy;2024 Konserhub. All rights reserved.</p>
        </div>
    </footer>
<script>
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
