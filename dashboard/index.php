<?php
session_start();
require_once '../db.php';

// Batasi jumlah event yang diambil, defaultnya 6 event
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 4;
$sql = "SELECT * FROM event_konser WHERE status_event = 'open' LIMIT :limit";
$stmt = $db->prepare($sql);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();
$resultEvents = $stmt;

// Ambil total jumlah event untuk menghitung apakah masih ada event lain yang belum ditampilkan
$sqlTotal = "SELECT COUNT(*) FROM event_konser WHERE status_event = 'open'";
$totalEvents = $db->query($sqlTotal)->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konserhub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="icon" href="../brand/icon.png" type="image/x-icon">
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

        .slide-in-elliptic-bottom-fwd {
            -webkit-animation: slide-in-elliptic-bottom-fwd 0.7s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
                    animation: slide-in-elliptic-bottom-fwd 0.7s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
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
            setInterval(showSlides, 5000); 
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
        <img src="slide/slide1.jpg" alt="Slide 1">
        <img src="slide/slide2.jpg" alt="Slide 2">
        <img src="slide/slide3.jpg" alt="Slide 3">
        <img src="slide/slide4.jpg" alt="Slide 3">
        <img src="slide/slide5.jpg" alt="Slide 3">
    </div>

    <!-- Content Section -->
    <section class="bg-transparent py-20 relative mt-2">
    <div class="container mx-auto px-4 text-center relative z-10">
        <h1 class="text-4xl font-bold text-white">
            Experience the Best Concerts
        </h1>
        <p class="text-white mt-4">Your hub for live music events.</p>
        <a href="events.php">
            <button class="mt-6 px-6 py-3 bg-[#7B61FF] text-white rounded-md shadow-lg hover:bg-[#6A52E0]">
                Get Started
            </button>
        </a>
    </div>
</section>

<!-- Content Section -->
<section class="container mx-auto mt-10 p-5 bg-white rounded shadow">
    <h1 class="text-center text-3xl font-bold mb-5">Upcoming events</h1>

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

    <?php if ($resultEvents->rowCount() > 0): ?>
        <div class="relative">
            <!-- Navigation Buttons -->
            <button class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-[#7B61FF] text-white p-2 rounded-full shadow hover:bg-[#6A52E0] z-10" onclick="slideLeft()">
                &#10094;
            </button>
            <button class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-[#7B61FF] text-white p-2 rounded-full shadow hover:bg-[#6A52E0] z-10" onclick="slideRight()">
                &#10095;
            </button>
            
            <div id="event-slider" class="flex overflow-x-auto scroll-smooth gap-5 mx-auto w-full max-w-5xl px-5 pb-5">
                <?php while($row = $resultEvents->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="flex-shrink-0 w-80 relative flex flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-md">
                        <div class="relative h-40 overflow-hidden rounded-t-xl bg-gray-300">
                            <?php if ($row['banner_event']): ?>
                                <img src="../upload/<?= htmlspecialchars($row['banner_event']) ?>" alt="banner_event" class="object-cover w-full h-full">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-gray-600">No banner</div>
                            <?php endif; ?>
                        </div>
                        <div class="p-6">
                            <h2 class="mb-2 text-xl font-bold leading-snug tracking-normal text-[#7B61FF] antialiased">
                                <?= htmlspecialchars($row['nama_event']) ?>
                            </h2>
                            <p class="block font-sans text-base font-light leading-relaxed text-gray-700 antialiased">
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
                        <div class="p-6 pt-0">
                            <a href="regis.php?id_event=<?= htmlspecialchars($row['id_event']) ?>" class="select-none rounded-lg bg-[#7B61FF] py-3 px-6 text-center font-sans text-xs font-bold uppercase text-white shadow-md transition-all hover:bg-[#7B61FF]/90">
                                Register
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center mt-5">
            <p class="text-gray-600">Tidak ada event konser yang terbuka saat ini.</p>
        </div>
    <?php endif; ?>
    </section>
    <script>
    const slider = document.getElementById('event-slider');

    function slideLeft() {
        slider.scrollLeft -= 300; // Adjust the value as needed
    }

    function slideRight() {
        slider.scrollLeft += 300; // Adjust the value as needed
    }


    </script>
    <style>
        /* Hide scrollbar for all browsers */
        #event-slider {
            -ms-overflow-style: none;  /* Internet Explorer 10+ */
            scrollbar-width: none;     /* Firefox */
        }

        #event-slider::-webkit-scrollbar {
            display: none; /* Safari and Chrome */
        }
    </style>
        <?php if ($limit < $totalEvents): ?>
            <div class="text-center mt-5 mb-6"> 
                <br>
                <a href="events.php?limit=<?= $limit + 6 ?>" class="mt-6 px-6 py-3 bg-[#7B61FF] text-white rounded-md shadow-lg hover:bg-[#6A52E0]">See More ></a>
                <br>
            </div>
        <?php endif; ?>
    </section>

    <section class="py-16 bg-gray-100">
      <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-black mb-8">Our Services</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg">
            <h3 class="text-xl font-semibold text-[#7B61FF] mb-2">
              Event Listings
            </h3>
            <p class="text-gray-700">Find concerts happening near you.</p>
          </div>
          <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg">
            <h3 class="text-xl font-semibold text-[#7B61FF] mb-2">
              Ticket Booking
            </h3>
            <p class="text-gray-700">
              Book tickets to your favorite events seamlessly.
            </p>
          </div>
          <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg">
            <h3 class="text-xl font-semibold text-[#7B61FF] mb-2">
              Exclusive Merchandise
            </h3>
            <p class="text-gray-700">Get exclusive band merchandise.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="py-16 bg-white">
      <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-black mb-8">What Our Users Say</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div class="bg-white p-6 rounded-lg shadow-md">
            <p class="text-gray-700">
              "Konserhub made finding live events so easy!"
            </p>
            <h4 class="mt-4 font-semibold text-black">P. Diddy</h4>
          </div>
          <div class="bg-white p-6 rounded-lg shadow-md">
            <p class="text-gray-700">"A must-have for all music lovers."</p>
            <h4 class="mt-4 font-semibold text-black">Beyonce</h4>
          </div>
        </div>
      </div>
    </section>

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

<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

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